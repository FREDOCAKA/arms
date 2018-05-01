<?php

namespace App\Validation\Rules;

use Slim\Http\Request  as Request;

use Respect\Validation\Rules\AbstractRule;

class ValidUpload extends AbstractRule
{

   

    public function validate($input)
    {
      
        $file = $this->request->getUploadedFile();

        $newFile =  $file['file'];

        if($newFile->getError()=== UPLOAD_ERR_OK)
        {

            $mediaType = $newFile->getClientMediaType();

        

        }
          
        
        
        if(isset($_FILES['file']) && !empty($_FILES['file']['name']))
            {
                $name = $_FILES['file']['name'];
                $type = $_FILES['file']['type'];
                $size = $_FILES['file']['size'];

                $file_type = explode('.',$name);
               
                $mime      = end($file_type);
                

                $allowedTypes = array('doc','docx','pdf','xls','xlsx','jpeg','jpg','png');


                in_array($mime,$allowedTypes) ? true: false;
            }
            return true;
        
          
      

    }


}