<?php

function dynamicInsert($table_name, $assoc_array){
    $keys = array();
    $values = array();
    foreach($assoc_array as $key => $value){
        $keys[] = $key;
        $values[] = addslashes( $value);
    }
    return "INSERT INTO $table_name(`".implode("`,`", $keys)."`) VALUES('".implode("','", $values)."')";
}

function dynamicUpdate($table_name, $assoc_array,$condition){
    $keyEgalValue=array();
    foreach($assoc_array as $key => $value){
        $keyEgalValue[] = addslashes($key)." = '".addslashes( $value)."'";
    }
    return "update $table_name set ".implode(",", $keyEgalValue)." ".$condition;
}

function dynamicCondition($assoc_array,$operateur){
    if(count($assoc_array)==0){
        return "";
    }
    $keyOperateurValue=array();
    foreach($assoc_array as $key => $value){
        $keyOperateurValue[] = addslashes($key)." ".$operateur." '".addslashes( $value)."'";
    }
    return "where ".implode(" and ", $keyOperateurValue);
}
function mode($mode_deploiement){
    if($mode_deploiement){
        echo "<h1>Mode déploiement activé</h1>";
        exit;
    }
}
function get_url(){
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];    
      
    return $url;  
}
function get_exemple($table_name){
    return '<pre>
            get_'.$table_name.'(){
                let api_url="'.get_url().'get"; // recevoir tout
                //let api_url="'.get_url().'get?id_'.$table_name.'=1"; // recevoir le(a) '.$table_name.' d\'identifiant 1

                this.http.get(api_url).subscribe((reponse:any)=>{
                    //when success
                    if(reponse.status){
                        console.log("Opération effectuée avec succés sur la table '.$table_name.'. Réponse= ",reponse);
                    }else{
                        console.log("L\'opération sur la table '.$table_name.' a échoué. Réponse= ",reponse);
                    }
                },
                (error:any)=>{
                    //when error
                    console.log("Erreur inconnue! ",error);
                })
            }
            </pre>';
}

function add_exemple($table_name,$description){
    
    $keysValues=array();
    foreach ($description as $key => $value) {
        if($value["Key"]=="PRI"){//cle primaire
            $keysValues[]=$value["Field"].":'".$value["Type"]." (primary key)'";
        }else{
            $keysValues[]=$value["Field"].":'".$value["Type"]."'";
        }
    }
    $ts_object=implode(",\n",$keysValues);
    return '<pre>
    add_'.$table_name.'('.$table_name.':any){
        /*
        '.$table_name.':any={
          '.$ts_object.'
        }
        */
        //transformation des parametres à envoyer
        let formdata=new FormData()
        for (const key in '.$table_name.') {
          formdata.append(key,'.$table_name.'[key])
        }
    
        let api_url="'.get_url().'add" 
        this.http.post(api_url,formdata).subscribe((reponse:any)=>{
          //when success
          if(reponse.status){
            console.log("Opération effectuée avec succés sur la table '.$table_name.'. Réponse= ",reponse)
          }else{
            console.log("L\'opération sur la table '.$table_name.' a échoué. Réponse= ",reponse)
          }
        },
        (error:any)=>{
          //when error
          console.log("Erreur inconnue! ",error)
        })
      }
            </pre>';
}
function edit_exemple($table_name,$description){
    
    $keysValues=array();
    foreach ($description as $key => $value) {
        if($value["Key"]=="PRI"){//cle primaire
            $keysValues[]=$value["Field"].":'".$value["Type"]." (primary key, obligatoire)'";
        }else if($value["Key"]=="MUL"){//cle primaire
            $keysValues[]=$value["Field"].":'".$value["Type"]." (primary étrangère, obligatoire)'";
        }else if($value["Null"]=="NO"){//cle primaire
            $keysValues[]=$value["Field"].":'".$value["Type"]." (obligatoire)'";
        }else{
            $keysValues[]=$value["Field"].":'".$value["Type"]." (facultatif)'";
        }
    }
    $ts_object=implode(",\n",$keysValues);
    return '<pre>
    edit_'.$table_name.'('.$table_name.':any){
        /*
        '.$table_name.':any={
          '.$ts_object.'
        }
        */
        //transformation des parametres à envoyer
        let formdata=new FormData()
        for (const key in '.$table_name.') {
          formdata.append(key,'.$table_name.'[key])
        }
    
        let api_url="'.get_url().'edit" 
        this.http.post(api_url,formdata).subscribe((reponse:any)=>{
          //when success
          if(reponse.status){
            console.log("Opération effectuée avec succés sur la table '.$table_name.'. Réponse= ",reponse)
          }else{
            console.log("L\'opération sur la table '.$table_name.' a échoué. Réponse= ",reponse)
          }
        },
        (error:any)=>{
          //when error
          console.log("Erreur inconnue! ",error)
        })
      }
            </pre>';
}
function delete_exemple($table_name,$description){
    
    $keysValues=array();
    foreach ($description as $key => $value) {
        if($value["Key"]=="PRI"){//cle primaire
            $keysValues[]=$value["Field"].":'".$value["Type"]." (primary key, obligatoire)'";
        }
    }
    $ts_object=implode(",\n",$keysValues);
    return '<pre>
    delete_'.$table_name.'('.$table_name.':any){
        /*
        '.$table_name.':any={
          '.$ts_object.'
        }
        */
        //transformation des parametres à envoyer
        let formdata=new FormData()
        for (const key in '.$table_name.') {
          formdata.append(key,'.$table_name.'[key])
        }
    
        let api_url="'.get_url().'delete" 
        this.http.post(api_url,formdata).subscribe((reponse:any)=>{
          //when success
          if(reponse.status){
            console.log("Opération effectuée avec succés sur la table '.$table_name.'. Réponse= ",reponse)
          }else{
            console.log("L\'opération sur la table '.$table_name.' a échoué. Réponse= ",reponse)
          }
        },
        (error:any)=>{
          //when error
          console.log("Erreur inconnue! ",error)
        })
      }
            </pre>';
}
function table_documentation($table_name,$description){
    $dir    = './';
    $files = scandir($dir);
    foreach ($files as $key => $value) {
        if($value!="." && $value!=".."  && $value!="index.php"  && $value!="config.php" ){
            $action=str_replace(".php","",$value);
            echo "<li>$action <a href='./$action'> --------> voir exemple</a></li>";
            if ($action=="add") {
                echo add_exemple($table_name,$description);
            } else if ($action=="edit") {
                echo edit_exemple($table_name,$description);
            } else if ($action=="get") {
                echo get_exemple($table_name);
            } else if ($action=="delete") {
                echo delete_exemple($table_name,$description);
            }
        }
    }
}
?>