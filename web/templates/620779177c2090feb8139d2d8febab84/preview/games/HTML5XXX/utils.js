window.requestAnimFrame = (function(){
          return  window.requestAnimationFrame       || 
                  window.webkitRequestAnimationFrame || 
                  window.mozRequestAnimationFrame    || 
                  window.oRequestAnimationFrame      || 
                  window.msRequestAnimationFrame     || 
                  function(/* function */ callback, /* DOMElement */ element){
                    window.setTimeout(callback, 1000 / 60);
                  };
    })();

    /**
     *  download a file 
     * @param {type} reqUri the url of the file
     * @param {type} async async->true/sync->false, freeze browser when sync
     * @param {type} callback  function to be called after download
     * @param {type} type   type of the file
     * @returns {undefined} 
     */

    function xhrGet(reqUri,  callback, async, type)
             {
                 
                 var _async = true;
                 if(async)
                 {
                     _async = async;
                 }
                 //caller function
                 var caller = xhrGet.caller;
                 //create a new XMLHttpRequest
                 var xhr= new XMLHttpRequest();
                 //Get is faster than Post in most of cases //post : cached file, send large amout of data(not size limit) , user inputs (post more secure/robust than get)
                 //async=false if little amout of request , freeze javascript
                 xhr.open("GET",reqUri,_async);
                 //type of file
                 if(type){
                     xhr.responseType = type;
                 }
                 //download + (onreadystatechange /readyState == 4 , status == 200 | download txt ~~ ajax)
                 xhr.onload = function(){
                     if(callback){
                        try{
                            //send request result
                          callback(this.responseText);
                       
                         // console.log("ok")
                        }catch(e)
                     {  //show info about failure ! 
                         throw 'xhrGet failed:\n'+ reqUri +'exceptionText:'+ e +' caller:'+caller;
                     }
                 }   
             }
                 //stop the request
                 xhr.send();

        console.log("loading of :"+reqUri)
                                    
             }
             
             /**
              * logique symplifiée
              */
                             /*
                  * Telecharge un fichier ! 
                 
                function xhrGet(reqUri, callback)
             {
                 var xhr= new XMLHttpRequest();
                 xhr.open("GET",reqUri,true);
                 xhr.onload = function(){
                        callback(this.responseText);
                      }
                 ;
                 xhr.send();
                                    
             } */


                function parseJson(JSONOBJ){
                
               //  console.log(parsed["sheets"]["sheet1.png"]["frames"]["4"]["y"]); 
                 return JSON.parse(JSONOBJ);
              
                };
                
                
       /*// transforme text en JSON
           //puis l'envoi a l'initialisateur
             var parseJson = function(JSONOBJ){
                
               //  console.log(parsed["sheets"]["sheet1.png"]["frames"]["4"]["y"]); 
                 initSheets(JSON.parse(JSONOBJ));
             
                }; */

    /**
             * 
             */
                 function $sheets(item)
            {
                item = "data/" + item + "Sprite.png";
                return sheets[item]
            }
        

            function loadSheet(nameStr)
            {

                xhrGet("/Game/GAMER/games/HTML5XXX/" + nameStr + "Json.json", function(raw){ var jsonObj = parseJson(raw); var sheet = new SheetClass(jsonObj);});
            }
            
               function anime(nameStr, posX, posY, loop, tickPerFrame)
            {
                nameStr = "data/" + nameStr + "Sprite.png";
                if (sheets[nameStr])
                {
                    var anim = new animClass(nameStr, posX, posY, loop, tickPerFrame);
                    if (anim)
                    {
                        animations.push(anim)


//                        console.log(nameStr + " added at x:" + posX + ",y :" + posY)
                        return anim;
                    }
                }


            }
           loadSheet("kiss");
           loadSheet("heart");
           loadSheet("heartOff");
            hand = (x, y) => anime("hand", x, y, true,20)
            handcatch = (x, y) => anime("handcatch", x, y, false,6)
            heart = (x, y) => anime("heart", x, y, true,20)
            heartOff = (x, y) => anime("heartOff", x, y, false,3)
           