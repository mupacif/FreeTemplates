/* global Class */

//// Utilitaire 
/**
 * 
 * Class definissant un sprite animé
 */
var sheets = {};
var SheetClass = Class.extend({
    //image 
    img: null,
    // url 
    url: "",
    //Sprites
    sprites: null,
    ticksPerFrame: 6,
    numberOfFrames: 17,
    loop: true,
    frameIndex: 0,
    tickCount: 0,
    //constructor
    init: function (jsonObj) {
            
       //load url 
                this.load(jsonObj.meta.image);
                //loadsprites
                this.shoeBoxSprites(jsonObj["frames"]);
    },
    //load image
    load: function (imgName)
    {
        //store url
        this.url = imgName;
        //store image
        var img = new Image();
        img.src = imgName;

        //store
        this.img = img;


        sheets[imgName] = this;

    },
    //function to store a sprite

    defSprite: function (name, x, y, w, h, xx, yy)
    {
        var spt = {
            "id": name,
            "x": x,
            "y": y,
            "w": w,
            "h": h,
            "xx": xx,
            "yy": yy
        };

        this.sprites.push(spt);
    },
    /*
     * 
     */

    shoeBoxSprites: function (jsO,callback) {

        var key = null;
        var val = null;
        this.sprites = []
        for (var i in jsO)
        {
            key = i;
            val = jsO[i];
            this.defSprite(i, val["frame"]["x"], val["frame"]["y"], val["frame"]["w"], val["frame"]["h"], 0, 0);
        }
        this.numberOfFrames = this.sprites.length;
        if(callback)
        callback()

    },
    getStats: function (indexInt)
    {

        return this.sprites[indexInt];

    },
    update: function (posX, posY)
    {

        this.tickCount += 1;

        if (this.tickCount > this.ticksPerFrame) {

            this.tickCount = 0;

            // If the current frame index is in range
            if (this.frameIndex < this.numberOfFrames - 1) {
                // Go to the next frame
                this.frameIndex += 1;
            } else if (this.loop) {
                //reset when winish
                this.frameIndex = 0;
            }


        }
        var sprite = this.getStats(this.frameIndex);
        if (sprite == null)
            return;

        _drawSpriteInternal(sprite, this, posX, posY);
        return;

    }

});

/**
 *  Find name of sprite in all sprite sheets
 * @param {type} spritename the name of the sprite
 * @param {type} posX the X position on the canvas
 * @param {type} posY the Y positons on the canvas
 * @returns {undefined} leave
 */
function drawSprite(spritename, posX, posY, nameStr)
{
    var sprite = null;
    //si le nom est donnée aller directement au nom
    if (nameStr && sheets[nameStr])
    {

        var sheet = sheets[nameStr];
        sprite = sheet.getStats(spritename);
        if (sprite == null)
            return;

        _drawSpriteInternal(sprite, sheet, posX, posY);
        return;
    } else
    {   //recherche si pas de nom

        for (var sheetName in sheets)
        {

            var sheet = sheets[sheetName];
            sprite = sheet.getStats(spritename);
            if (sprite == null)
                continue;

            _drawSpriteInternal(sprite, sheet, posX, posY);
            return;
        }
    }
}

function _drawSpriteInternal(spt, sheet, posX, posY)
{
    if (spt == null || sheet == null)
        return;

 
    // Clear the canvas
   
  ctx.clearRect(posX, posY, spt.w, spt.h);
    
 
    ctx.drawImage(sheet.img, spt.x, spt.y, spt.w, spt.h,
            posX, posY,
            spt.w, spt.h);
           
      

}

var animClass = Class.extend({
    ticksPerFrame: 6,
    numberOfFrames: 17,
    loop: true,
    frameIndex: 0,
    tickCount: 0,
    sheet: 0,
    posX:0,
    posY:0,
    main:false,
    finished: false,
    init: function (sheetSprite, posX ,posY, loop, tpf) {
        if (sheets[sheetSprite])
        {
//            console.log(sheetSprite)
            this.sheet = sheets[sheetSprite]
            this.posX=posX;
            this.posY=posY;
            
            this.numberOfFrames=this.sheet.numberOfFrames;
            if(typeof loop == "boolean")
            {
               this.loop = loop;
            

            }
           
            if(typeof tpf == "number")
            {
            this.ticksPerFrame = tpf;
            }else
            {
                this.ticksPerFrame = this.sheet.ticksPerFrame;
            }
//             console.log(sheetSprite+" animation added"+((this.loop)?"looped":"not looped")+" timeperFrame:"+this.ticksPerFrame)
        }
        
       
    },
    update:function(posX, posY)
    {
               this.tick++;
               this.tickCount += 1;

        if (this.tickCount > this.ticksPerFrame) {

            this.tickCount = 0;

            // If the current frame index is in range
            if (this.frameIndex < this.numberOfFrames - 1) {
                // Go to the next frame
                this.frameIndex += 1;
            } else{
                //reset when winish
                if (this.loop) 
                     this.frameIndex = 0;
                else
                     this.finished=true;   
            }


        }

            
        var sprite = this.sheet.getStats(this.frameIndex);
        if (sprite == null)
            return;

        _drawSpriteInternal(sprite, this.sheet, posX, posY);
        return;
    }
});

var timeElementClass = Class.extend({
        time:0,
        animation: null,
        music:null,
        posX:0,
        posY:0,
        finished:false,
        init:function(animation,posX,posY, duration, music, start)
        {
            
            this.posX=posX;
            this.posY=posY;
            this.animation = new animClass(animation,posX,posY);
            this.time = new Date().getTime()+duration*1000;
            
            if(music)
            {
                this.music=music;
                gSM.playSound("data/"+music+".mp3",{looping:true, volume:0.7, time:start?start:10,during:duration});
            }
            
        },
        update:function(posx,posY)
        {
            
            this.animation.update(posx,posY);
            
            if(new Date().getTime()>= this.time)
            {
                this.animation.finished=true;
                if(this.music)
                gSM.stopAll();
                this.finished = true;
            }
        }
        
})


