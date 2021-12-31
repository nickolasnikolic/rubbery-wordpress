window.onload = () => {

    let mouseLocation = {
        x: 0,
        y: 0
    };
    
    window.addEventListener('mousemove',(event) => {
        mouseLocation.x = event.pageX;
        mouseLocation.y = event.pageY;
    });
    
    const canvas = document.getElementById('poetry');
    
    //set a few defaults based upon screen size
    //if the monitor is a 4k or larger screen
    let lineLetterCount = 0; //noticible default
    if(window.innerHeight > 2000){
        canvas.height = window.innerWidth;
        lineLetterCount = 21; //used in laying the letters later
    }else{
        canvas.height = window.innerHeight * 2.8;
        lineLetterCount = 16;
    }

    canvas.width = window.innerWidth;
    
    canvas.style.position = 'absolute';
    canvas.style.top = 0;
    canvas.style.left = '-2.8em';
    canvas.style.zIndex = -1;
    const context = canvas.getContext('2d');
    
    
    class Poem{
        constructor(poem){
            this.poemOriginal = poem;
            this.title = poem.title;
            this.poet = poem.poet;
            this.poem = poem.poem;
            this.letters = [];
        }
    
        mincePoem() {
            let name = this.poet + '::';        
            let lines = this.poem.match(/(.*){,23}/g);
            
            nameArray = Array.from(name);
            let linesArray = Array.from(lines);
            
            let letters = nameArray.concat(linesArray);
    
            this.letters = letters;
            return letters;
        };
    
        mincePoemByPunctuation(){
            let name = this.poet + '::'; 
            let intermediary = name + this.poem; 
            let lines = intermediary.match(/(.*)[.,;\\?"']/g);
    
            let letters = Array.from(lines);
    
            this.letters = letters;
            return letters;
        }
    
        mincePoemByCharacter(){
            let name = this.poet + '::';  
            let letters = Array.from(name + this.poem + '||');
    
            this.letters = letters;
            return letters;
        }    
    
        getLetters(){
            return this.letters;
        }
    }
    
    class Letter{
        constructor(letter, x, y){
            this.letter = letter;
            this.x = x;
            this.y = y;
            this.originalX = x;
            this.originalY = y;
            this.sensitivityRadius = 50;
        }

        setColor(colorToSet){
            context.strokeStyle = colorToSet;
        }
    
        drawLetter(){
            context.font = '88px isidoralight';
            context.lineWidth = 0.28;
            context.strokeText(this.letter, this.x, this.y);
        }
    
        updateDistanceFromMouse(){
            const frictionMultiplier = 0.1;
            let distanceX = mouseLocation.x - this.x;
            let distanceY = mouseLocation.y - this.y;
    
            let distanceToMouse = Math.ceil(Math.sqrt(Math.pow(distanceX, 2) + Math.pow(distanceY, 2)));
            
            let forceX =  (distanceX / distanceToMouse);
            let forceY =  (distanceY / distanceToMouse);
    
            let maximumDistance = this.sensitivityRadius;
            let force = maximumDistance - distanceToMouse / maximumDistance * frictionMultiplier;
            let directionX = forceX * force * frictionMultiplier;
            let directionY = forceY * force * frictionMultiplier;
        
            if(distanceToMouse < this.sensitivityRadius){
                this.x += directionX;
                this.y += directionY;            
                this.drawLetter();
            }else{
                this.size = this.originalSize;
                this.lineThickness = this.originalStrokeThickness;
                if(this.x != this.originalX){
                    let distanceX = this.x - this.originalX;
                    this.x -= distanceX / 10;
                    this.drawLetter();
                }
                if(this.y != this.originalY){
                    let distanceY = this.y - this.originalY;
                    this.y -= distanceY / 10;
                    this.drawLetter();
                }
            }
            
        }
    }
    
    const globalArrayOfPoems = [];
    const collectionToAnimate = [];
    function getPoetry(url){
        const x = new XMLHttpRequest();
        x.onreadystatechange = () => {
            if(x.readyState == 4){
                const data = JSON.parse(x.response);
    
                if(data.result === undefined){
                    data.result = [
                    {
                        title: 'sleep',
                        poet: 'nickolas nikolic',
                        poem: 'today, tomorrow, or the next day; I have no sleep. gruesome tides pull sailors in, and out, while mollusks enjoy plankton calm and sleep the shuckers by. History sleeps there, as well, and pulls no words from their tight mother-pearl slits.'
                    },{
                        title: 'Ride',
                        poet: 'nickolas nikolic',
                        poem: 'Rilke only owns that which is ours by definition. Toward a final resting place the meaning lilts onward. Most people think he was such a great guy, you know, supportive, But meaning might just know otherwise. Tomorrow a wedding whilst today awaiting it, but later still, meaning awaits curled in an infant suckle.'
                    }
                ]
                };
    
                data.result.forEach( poem => {
                    let p = new Poem(poem);
                    p.mincePoemByCharacter();
                    globalArrayOfPoems.unshift(p.getLetters().filter( letter => (letter != ' ' || letter != '\n' )) );
                });
                
                const poemLettersArray = globalArrayOfPoems.flat();
                
                const startX = 480;
                const xWidth = 90;
                const lineHeight = 90;
                let xOffset = startX;
                let yOffset = 100;
    
                function layLetter(letter){
                    let l = new Letter( letter, xOffset, yOffset );
                    context.strokeStyle = "#99f";
                    l.drawLetter();
                    collectionToAnimate.push(l);
                }
    
                poemLettersArray.forEach( (element, index) => {
                    // if the letter is not a newline
                    if(index % lineLetterCount != 0){
                        // place at an increasing x
                        xOffset += xWidth;
                        layLetter(element);
                    } else {
                        // if it is a newline
                        // reset x (move back to left margin) and increase y (lower down the screen)
                        xOffset = startX;
                        yOffset += lineHeight;
                        layLetter(element);
                    }
                });
    
            }
        };
        x.open('get', url);
        x.send();
    }
    
    getPoetry('https://rubbery.fun/wordpress/api/');
    
    window.addEventListener('resize', () => {
        context.clearRect(0,0, canvas.width, canvas.height);
        collectionToAnimate.forEach((element, index) => {
            element.updateDistanceFromMouse();
        });
    });

    function animate(){
        context.clearRect(0,0, canvas.width, canvas.height);
        collectionToAnimate.forEach((element, index) => {
            element.setColor(`#ccc`);
            element.updateDistanceFromMouse();
        });
        requestAnimationFrame(animate);
    }
    animate();
    
    }