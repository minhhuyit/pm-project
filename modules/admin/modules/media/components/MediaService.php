<?php
namespace admin\modules\media\components;

use admin\components\services\BaseAdminService;
use admin\modules\media\models\Media;
use app\models\Post;
use app\models\Postmeta;
use yii\db\IntegrityException;
use yii\helpers\Url;

/**
 * MediaService post data service
 *
 * @author Phong
 */
class MediaService extends BaseAdminService {

    const UPLOAD_FOLDER = 'uploads'.DIRECTORY_SEPARATOR ;

    // List all files extend upload
    public $extType = [
        'image'       => [ 'jpg', 'jpeg', 'jpe',  'gif',  'png',  'bmp',   'tif',  'tiff', 'ico' ],
        'audio'       => [ 'aac', 'ac3',  'aif',  'aiff', 'm3a',  'm4a',   'm4b',  'mka',  'mp1',  'mp2',  'mp3', 'ogg', 'oga', 'ram', 'wav', 'wma' ],
        'video'       => [ '3g2',  '3gp', '3gpp', 'asf', 'avi',  'divx', 'dv',   'flv',  'm4v',   'mkv',  'mov',  'mp4',  'mpeg', 'mpg', 'mpv', 'ogm', 'ogv', 'qt',  'rm', 'vob', 'wmv' ],
        'document'    => [ 'doc', 'docx', 'docm', 'dotm', 'odt',  'pages', 'pdf',  'xps',  'oxps', 'rtf',  'wp', 'wpd', 'psd', 'xcf' ],
        'spreadsheet' => [ 'numbers',     'ods',  'xls',  'xlsx', 'xlsm',  'xlsb' ],
        'interactive' => [ 'swf', 'key',  'ppt',  'pptx', 'pptm', 'pps',   'ppsx', 'ppsm', 'sldx', 'sldm', 'odp' ],
        'text'        => [ 'asc', 'csv',  'tsv',  'txt' ],
        'archive'     => [ 'bz2', 'cab',  'dmg',  'gz',   'rar',  'sea',   'sit',  'sqx',  'tar',  'tgz',  'zip', '7z' ],
        'code'        => [ 'css', 'htm',  'html', 'php',  'js' ],
    ];

    /**
     * Get type of file depend on file extend
     * @param string $file is name of file
     * @return string  $type is type of file
     **/
    public function getType($file){
        $ext = array_pop(explode('.', basename($file)));
        foreach ( $this->extType as $type => $exts )
            if ( in_array( $ext, $exts ) )
                return $type;
    }

    /**
     * @param $file
     * @return bool
     */
    public function isImage($file){
        $type = $this->getType($file);
        return 'image' == $type ? true : false;
    }

    /**
     * Get url using display
     * @param $file
     * @return string is url of picture or icon for display
     */
    public function getDisplayImage($file){
        $type = $this->getType($file);
        if ($this->isImage($file)) {
            return str_replace('\\', '/', self::UPLOAD_FOLDER . $file);
        } else {
            return 'images/filetypes/' . $type . '.png';
        }
    }


    /**
     * Get file upload and save to DB, upload to server
     **/
    public function uploadMedia(){

        if(empty($_FILES['file'])){
            echo json_encode(['error' => 'No files found ']);
            return;
        }

        $files = $_FILES['file'];
        $success = null;
        $filenames = $files['name'];

        if(empty($this->getType($filenames['0']))){
            echo json_encode(['error' => 'The file upload have not allowed!']);
            return;
        }
        $name = md5(uniqid());
        $folder = date('Y', time()).DIRECTORY_SEPARATOR.date('m', time());
        if(!file_exists(self::UPLOAD_FOLDER.$folder)){
            mkdir(self::UPLOAD_FOLDER.$folder,0777,true);
        }
        $ext = explode('.', basename($filenames['0']));

        $target = $folder. DIRECTORY_SEPARATOR . $name . '.' . array_pop($ext);
        if(move_uploaded_file($files['tmp_name']['0'], self::UPLOAD_FOLDER.$target)){
             $success = true;
        } else{
             $success = false;
        }
        if($success === true){
                $post = new Post();
                $post->author = \Yii::$app->user->identity->id;
                $post->title = array_pop($ext);
                $post->name = $files['name']['0'];
                $post->status ='draft';
                $post->type ='media';
                $post->mime_type = $files['type']['0'];
                $post->created_date = \date(time());

                $media = new Media();
                $media->_attached_file = str_replace('\\','/',$target);
                if(\Yii::$app->post->savePostData($post, $media)){
                    $url = \Yii::$app->adminModule->createAdminUrl(['media/upload?id='.$post->id]);
                    $output = ['id' => $url];
                }
        } else if($success === false){
                   $output = ['error' => 'Error while uploading images'];
        }else{
             $output = ['error' => 'No file were processed'];
        }
        echo json_encode($output);
    }


    /**
     * @param $postId
     * @return array|\yii\db\ActiveRecord[]
     * @throws NotFoundHttpException
     */
    public function getAllMetas($postId){
        if (($model = Postmeta::find()->where(['post_id' => $postId])->all()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function deleteMedia($post){
        if( $post->delete()){
                $models = \Yii::$app->adminModule->mediaService->getAllMetas($post->id);
                $image = \Yii::$app->post->getMeta($post->id,'_attached_file');
                foreach ($models as $model) {
                    $model->delete();
                }
                if(file_exists(self::UPLOAD_FOLDER.$image)) {
                    unlink(self::UPLOAD_FOLDER . $image);
                }
        }
    }

    /**
     * Get all post data have type is 'media' follow condition search
     * @param PostSearch $postSearch is condition search
     * @return SqlDataProvider $dataProvider
     */
    public function getPostDataProvider($postSearch) {

        $condition = 'AND (title like :title OR name like :title OR username like :title)';
        $sql_list_media = 'SELECT'
                            . ' post.id as id'
                            . ',title'
                            . ',status'
                            . ',excerpt'
                            . ',name'
                            . ',username as author'
                            . ',post.created_date as created_date'
                            . ',pm.meta_value as picture'
                        . ' FROM post '
                        . ' INNER JOIN user ON user.id = post.author'
                        . ' INNER JOIN postmeta pm ON pm.post_id = post.id'
                        . ' WHERE type = "media"'
                        . ' AND pm.meta_key = "_attached_file"'
                        . $condition
                        ;
        $search_value =  '%'.$postSearch->title.'%';
        $count = \Yii::$app->db->createCommand(
               'SELECT COUNT(*)'
               . ' FROM user'
               . ' INNER JOIN post ON user.id = post.author'
               . ' INNER JOIN postmeta pm ON pm.post_id = post.id'
               . ' WHERE type = "media"'
               . ' AND pm.meta_key = "_attached_file"'
               . $condition,[':title' => $search_value]
             )->queryScalar();
        
        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $sql_list_media,
            'params' => [':title' => $search_value],
            'totalCount' => $count,
            'key'        => 'id',
            'sort' => [
                'attributes' => [
                    'title',
                    'author',
                    'status',
                ],
            ],
        ]);
        return $dataProvider;
    }

    /**
     * Get path for display icon or picture
     * @param $filename
     * @param bool $isFileUpload
     * @return string url
     * @internal param Url $string image
     */
    public function createMediaUrl($filename,$isFileUpload=false)
    {
        $baseUrl = $isFileUpload ? Url::base().DIRECTORY_SEPARATOR.self::UPLOAD_FOLDER : Url::base().DIRECTORY_SEPARATOR;
        return str_replace('\\','/',$baseUrl."$filename");
    }
}
