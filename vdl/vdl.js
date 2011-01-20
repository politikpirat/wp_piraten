var VDL = {

    // Was tut sie gerade?
    modes: ['idle', 'active'],
    mode: 0,        // aktueller Modus
    nextMode: 0,    // danach dieser Modus

    hardcore: false, // sollen auch die ganz üblen sachen kommen wie hundebabys?

    /**
     * Animations-Engine
     */

    trash: (navigator.userAgent.indexOf("MSIE 6")!=-1),
    // zählen, global und innerhalb einer Animation
    clock : 0,
    counter: 0,
    tickVal: 0, // für die Zehntelsekunden
    tick: function() {
        VDL.clock++;
        VDL.tickVal++;
        if(VDL.tickVal==10) {
            VDL.counter++;
            VDL.tickVal = 0;
        }
        VDL.eyes();
        VDL.animate();        // Modusabhängige Animation
    },
    animate: function(){},  // wird je nach aktion belegt
    currentAnimation: {     // zeigt auf Animations-JSON siehe unten
        destroy: function() {}
    },

    // Timeout-Funktionen:
    // verwaltung von timeouts und automatische löschung etc ...

    timeouts: {},

    // set time out
    sto: function(id, callback, time) {
        VDL.cto(id);
        VDL.timeouts[id] = setTimeout(function() {
            VDL.timeouts[id] = false;
            callback();
        }, time);
    },

    // clear time out
    cto: function(id) {
        if(VDL.timeouts[id]) {
            clearTimeout(VDL.timeouts[id]);
            VDL.timeouts[id] = false;
        }
    },

    face: 0,                // dieses Gesicht wird gerade angezeigt
    clicks: 0,
    carecounter: 10000,     // startwert für gerettete kinder

    pos: {
        eyes: {
            center: [
                {x:71, y:56},
                {x:97, y:56}
            ],
            width: 12,
            height: 4
        },
        pic: {
            x:5, y:5,
            width: 140,
            height: 144
        },
        bubble: {
            width: 300
        }
    },
    nodes: {eyes: []},
    data: {},

    // Animation wechselt
    change: function() {
        VDL.stopAnimation();
        VDL.hideBubble();

        // neue Animation aus zukünftigem Modus zufällig auswählen
        VDL.currentAnimation =
            VDL.actions[VDL.modes[VDL.nextMode]][Math.floor(Math.random()*VDL.actions[VDL.modes[VDL.nextMode]].length)];

        // ist das zu krass?
        if(!VDL.hardcore) {
            if(VDL.currentAnimation.hardcore) {
                VDL.change();
                return;
            }
        }

        VDL.mode = VDL.nextMode;

        if(VDL.mode==1) VDL.nextMode=0;
        if(VDL.mode==0) VDL.nextMode=1;

        VDL.startAnimation();
    },

    pic: function(n) {
        VDL.face = n;
        VDL.nodes.face.style.top = (-VDL.pos.pic.height*n) +"px";
    },

    stopAnimation: function() {
        VDL.counter = 0;
        VDL.cto('animationMode');
        // laufende Animation abschalten
        if(VDL.currentAnimation.destroy) VDL.currentAnimation.destroy()
        else VDL.pic(0);
        VDL.animate = function(){};
    },

    startAnimation: function() {
        if(VDL.currentAnimation.start) VDL.currentAnimation.start(); // init-Routs aufrufen
        if(VDL.currentAnimation.animate)
            VDL.animate = VDL.currentAnimation.animate               // In die Uhr hängen
        else
            VDL.animate = function(){};

        // Nach entsprechender Zeit neue Animation aussuchen
        VDL.sto('animationMode', VDL.change, VDL.currentAnimation.time*1000);
    },

    eyes: function() {
        for(var i=0;i<2;i++) {
            if(!VDL.data.mx) return; // nur wenn schon Mauskoordinaten vorliegen

            var dx = VDL.data.mx - (VDL.pos.eyes.center[i].x+VDL.pos.pic.x);
            var dy = VDL.data.my - (VDL.pos.eyes.center[i].y+VDL.pos.pic.y);

            var r=(dx*dx/VDL.pos.eyes.width+dy*dy/(VDL.pos.eyes.height/2)<1) ? 1 : Math.sqrt((VDL.pos.eyes.width/2)*(VDL.pos.eyes.height/2)/(dx*dx+dy*dy));

            with(VDL.nodes.eyes[i].style) {

                left= (r*dx+VDL.pos.eyes.center[i].x-10)+"px";
                top = ((r*dy/2)+VDL.pos.eyes.center[i].y-7)+"px";
            }
        }
    },

    ieScroll: function() {
        VDL.nodes.container.style.left = VDL.left();
        VDL.nodes.container.style.top  = VDL.top();
    },

    // Initialisierung der Start-Events
    init: function() {

        // Standard-konformer Browser?
        if ( document.addEventListener ) {

            document.addEventListener( "DOMContentLoaded", function(){
                document.removeEventListener( "DOMContentLoaded", arguments.callee, false );
                VDL.prepare();
            }, false );

        // Oder ist es der gute Internet-Explorer?
        } else if ( document.attachEvent ) {

            // Das funktioniert in IFRAMEs:
            document.attachEvent("onreadystatechange", function(){
                if ( document.readyState === "complete" ) {
                    document.detachEvent( "onreadystatechange", arguments.callee );
                    VDL.prepare();
                }
            });

            // Wenn wir nicht im IFRAME laufen muss kontinuierlich
            // geprüft werden, ob das DOM schon bereit ist
            if ( document.documentElement.doScroll && window == window.top ) (function(){
                if ( VDL.ready ) return;

                try {
                    document.documentElement.doScroll("left");
                } catch( error ) {
                    setTimeout( arguments.callee, 0 );
                    return;
                }

                // geschafft!
                VDL.prepare();
            })();
        } else {
            // Fallback, falls ein Exotenbrowser daherkommt:
            VDL.saveOnload = document.onload;   // Alte "onload"-Funktion sichern
            document.onload = VDL.onload;       // Eigene Funktion dem Event zuweisen
        }
    },

    // fallback
    onload: function() {
        VDL.prepare();
        // Falls eine Funktion gesichert wurde, diese ausführen.
        if(toString.call(OdemSTOPP.saveOnload) === "[object Function]")
            OdemSTOPP.saveOnload();
    },

    prepare: function() {
        if ( VDL.ready ) return;
        VDL.ready = true;
        VDL.create();
        VDL.interval = setInterval(VDL.tick, 100); // Sekunden-Takt
    },

    /* Reihenfolge in allen Breite/Höhe-Positions-Funktionen:
       - Standard-konforme Browser
       - IE 6 bzw im Quirks mode
       - restliche IEs
    */

    height: function() {
        if (window.innerHeight!=window.undefined) return window.innerHeight;
        if (document.compatMode=='CSS1Compat') return document.documentElement.clientHeight;
        if (document.body) return document.body.clientHeight;
        return undefined;
    },

    width: function() {
        if (window.innerWidth!=window.undefined) return window.innerWidth;
        if (document.compatMode=='CSS1Compat') return document.documentElement.clientWidth;
        if (document.body) return document.body.clientWidth;
        return undefined;
    },

    top: function() {
        if (self.pageYOffset) return self.pageYOffset;
        if (document.documentElement && document.documentElement.scrollTop) return document.documentElement.scrollTop;
        if (document.body) return document.body.scrollTop;
        return undefined;
    },

    left: function() {
        if (self.pageXOffset) return self.pageXOffset;
        if (document.documentElement && document.documentElement.scrollLeft) return document.documentElement.scrollLeft;
        if (document.body) return document.body.scrollLeft;
        return undefined;
    },

    addEvent: function(element, event, callback) {
        // Standard-konformer Browser?
        if ( element.addEventListener ) {
            element.addEventListener( event, callback, false );
        // Oder ist es der gute Internet-Explorer?
        } else if ( element.attachEvent ) {

            element.attachEvent("on"+event, callback);
        }
    },

    removeEvent: function(element, event, callback) {
        if ( element.removeEventListener ) {
            element.removeEventListener( event, callback, false )
        } else if ( element.detachEvent ) {
            element.detachEvent("on"+event, callback);
        }
    },

    // Elemente erzeugen
    create: function() {

        var head      = document.getElementsByTagName('head')[0];
        var body      = document.getElementsByTagName('body')[0];

        // Kein Head vorhanden?
        if(!head) {
            head = document.createElement('head');
            body.parentNode.insertBefore(head, body);
        }

        var cssURL = "/vdl/vdl.css";
        if(document.createStyleSheet) {
            document.createStyleSheet(cssURL);
        } else {
            var style = document.createElement('link');
            style.type = "text/css";
            style.href = cssURL;
            style.rel = "stylesheet";
            style.media ="screen";
            head.appendChild(style);
        }


        var container = document.createElement('div');
            container.id = "ZENSURSULA";
        var character = document.createElement('div');
            character.id = "Z_CHARACTER";


            var face = document.createElement('img');
                face.src = '/vdl/vdl.gif';
            var eyeL = document.createElement('img');
                eyeL.src = '/vdl/auge.gif';
            var eyeR = document.createElement('img');
                eyeR.src = '/vdl/auge.gif';

        var bubble    = document.createElement('div');
            bubble.id = "Z_BUBBLE";
        var innerBubble = document.createElement('div');
            innerBubble.id = "Z_INNERBUBBLE";
        var hookL = document.createElement('img');
            hookL.id = "Z_BUBBLEHOOK";
            hookL.src = "/vdl/hook.gif";
        var hookR = document.createElement('img');
            hookR.id = "Z_BUBBLEHOOK_R";
            hookR.src = "/vdl/hookr.gif";

        var stopSign = document.createElement('div');
            stopSign.id = "Z_STOPSIGN";
            VDL.addEvent(stopSign, 'click', function() {
                VDL.nodes.stopSign.style.display = "none";
            });

        VDL.nodes = {
            container:  container,
            character:  character,
            bubble:     bubble,
            innerBubble:innerBubble,
            stopSign:   stopSign,
            face:       face,
            hookL:      hookL,
            hookR:      hookR,
            eyes:       [eyeL, eyeR]
        };

        if(VDL.trash) {
            // IE 6 kann keine fixed-Position
            // daher muss der leider manuell mitscrollen
            container.style.position = "absolute";
            stopSign.style.position = "absolute";
            setInterval(VDL.ieScroll, 200);
        } else {
            container.style.position = "fixed";
            stopSign.style.position = "fixed";
        }

        for(var i=0;i<2;i++) {
            with(VDL.nodes.eyes[i].style) {
                left = (VDL.pos.eyes.center[i].x -9)+"px";
                top = (VDL.pos.eyes.center[i].y -7 )+"px";
            }
        }


        VDL.setPos();

        VDL.addEvent(character, "mousedown", VDL.startDrag); // verschiebbar!!

        character.appendChild(eyeL);
        character.appendChild(eyeR);
        character.appendChild(face);

        bubble.appendChild(innerBubble);
        bubble.appendChild(hookL);
        bubble.appendChild(hookR);

        container.appendChild(stopSign);
        container.appendChild(character);
        container.appendChild(bubble);
        body.appendChild(container);

        stopSign.innerHTML =
            '<div style="position:absolute;left:50%;top:50%;margin:0;padding:0;">\
                <div id="Z_ACTUALSTOPSIGN"></div>\
             </div>';



        VDL.addEvent(document, "mousemove", VDL.mousemove);

        VDL.addEvent(window, "resize", VDL.resize);
        VDL.resize();

        VDL.change();
    },

    setPos: function() {

        // VDL wird an die richtige Stelle geschoben
        with(VDL.nodes.character.style) {
            left = VDL.pos.pic.x+'px';
            top = VDL.pos.pic.y+'px';
        }

        if(VDL.pos.pic.x < (VDL.width()-VDL.pos.pic.width-VDL.pos.bubble.width-50)) {
            VDL.nodes.hookL.style.display = "block";
            VDL.nodes.hookR.style.display = "none";
            with(VDL.nodes.bubble.style) {
                left = (VDL.pos.pic.x+VDL.pos.pic.width+30)+'px';
                top = (VDL.pos.pic.y+30)+'px';
            }

        } else {
            VDL.nodes.hookL.style.display = "none";
            VDL.nodes.hookR.style.display = "block";
            with(VDL.nodes.bubble.style) {
                left = (VDL.pos.pic.x-VDL.pos.bubble.width-30)+'px';
                top = (VDL.pos.pic.y+30)+'px';
            }
        }
    },

    cancelEvent: function(e) {
        if(e.preventDefault) { // DOM
            e.preventDefault();
        } else { // IE
            e.returnValue = false;
        }
    },

    startDrag: function(e) {
        if(!e) e = window.event;

        VDL.dragstartX = VDL.pos.pic.x; // zum checken, ob sie gedragt oder geklickt wurde
        VDL.dragstartY = VDL.pos.pic.y;

        VDL.dragOffsetX = e.clientX - VDL.pos.pic.x;
        VDL.dragOffsetY = e.clientY - VDL.pos.pic.y;

        VDL.addEvent(document, "mousemove", VDL.drag);
        VDL.addEvent(document, "mouseup", VDL.stopDrag);

        VDL.cancelEvent(e);


    },
    stopDrag: function(e) {
        VDL.removeEvent(document, "mousemove", VDL.drag);
        VDL.removeEvent(document, "mouseup", VDL.stopDrag);

        VDL.cancelEvent(e);

        if( // wurde vdl nicht verschoben?
            VDL.dragstartX == VDL.pos.pic.x
        &&  VDL.dragstartY == VDL.pos.pic.y
        ) {
            VDL.click();
        }
    },

    drag: function(e) {
        if(!e) e = window.event;
        VDL.pos.pic.x = e.clientX-VDL.dragOffsetX;
        VDL.pos.pic.y = e.clientY-VDL.dragOffsetY;
        VDL.setPos();

        VDL.cancelEvent(e);
    },

    mousemove: function(e) {
        if(!e) e = window.event;
        VDL.data.mx = e.clientX;
        VDL.data.my = e.clientY;
    },

    resize: function() {
        with(VDL.nodes.stopSign.style) {
            width = VDL.width()+"px";
            height = VDL.height()+"px";
        }
    },

    showBubble: function(text) {
        VDL.cto('bubble');
        VDL.hideBubble();
        // bei bestimmten Gesichtern darf Ursula nich zu reden anfangen
        if(VDL.face==0) {
            VDL.faceSave = VDL.face;
            VDL.pic(1);
            VDL.sto('talk', function(){VDL.pic(VDL.faceSave)}, 2000);
        }
        VDL.nodes.innerBubble.innerHTML = text;
        VDL.sto('bubble', function(){VDL.nodes.bubble.style.display = "block";},200);

    },

    hideBubble: function() {
        VDL.cto('talk');
        //VDL.pic((VDL.faceSave) ? VDL.faceSave : 0);
        VDL.cto('bubble');
        VDL.nodes.bubble.style.display = "none";
    },

    click: function() {
        if(VDL.maintainanceMode) {
            VDL.cto('maintainance');
            VDL.maintainanceMode = false;
            VDL.hideBubble();
            VDL.startAnimation();
            VDL.nodes.stopSign.style.display = "none";
        } else {
            VDL.maintainanceMode = true;
            VDL.stopAnimation();
            VDL.pic(0);
            VDL.showBubble(
                'Darf ich mich vorstellen: mein Name ist Ursula von der Leyen. Willkommen in meinem <b>familienfreundlichen Internet!</b><br/><br/>Ich bin die erste Deutsche Familienministerin mit eigenem <a href="http://vdl.odem.org/">Fanclub</a>. <br/><br/>Hoffentlich haben sie nichts dagegen, wenn ich ihnen ein wenig &uuml;ber die Schulter blicke. Denn ich und meine Kollegen vom BKA bauen gerade ein praktisches <a href="http://www.heise.de/newsticker/Kinderporno-Sperren-An-Populismus-kaum-zu-ueberbieten--/meldung/137193">&Uuml;berwachungssystem f&uuml;rs Internet</a> auf.<br/><br/><button type="button" onclick="VDL.circumvent()">&Uuml;berwachung abschalten</button><br/><br/>Soll ich Sie auf Ihrer eigenen Webseite besuchen, m&uuml;ssen Sie dort nur eine <a href="http://vdl.odem.org/">Zeile Code einf&uuml;gen</a>. Ich freue mich auf eine gute Zusammenarbeit.<br/><img src="/vdl/sig.gif" width="113" height="49" />'
            );
            VDL.sto('maintainance', VDL.click, 20000);
        }
    },

    circumvent: function() {
        if(VDL.clicks==1) { // zweiter versuch, was mit ihr vdl zu machen
            VDL.removeEvent(VDL.nodes.character, "click", VDL.click);
            VDL.cto('talk');
            VDL.showBubble('Wie sie w&uuml;nschen, ich werde mich zur&uuml;ckziehen. &quot;Aus den Augen, aus dem Sinn&quot; ist schlie&szlig;lich auch mein Motto!');
            VDL.sto('coolness', function(){VDL.cto('talk'); VDL.hideBubble();VDL.pic(6);}, 5500);
            VDL.sto('goodbye', function(){VDL.nodes.container.style.display = "none"}, 7000);
        } else {
            VDL.cto('talk');
            VDL.pic(5);
            VDL.sto('maintainance', VDL.click, 10000);
            VDL.nodes.stopSign.style.display = "block";
            VDL.showBubble('<center><b><blink>&Uuml;berwachung abschalten??!</blink></b></center><br/><b><a href="http://www.golem.de/0904/66730.html">Sie geh&ouml;ren wohl zu den 20% der Internet-Benutzer, die schwer p&auml;dokriminell sind!</a> !!</b>!1');
            VDL.clicks++;
            VDL.sto('return', function(){VDL.pic(0);}, 3000);
        }
    },

    /**
     * Modus-abhängige Liste von Animationen.
     * - start: bevor es losgeht irgendwas initialisieren
     * - animate: wird in den Interval eingehängt
     * - time; Zeit in Millisekunden für Animation
     * - destroy: wird beim Ende der Animation aufgerufen
     * - hardcore: flag, ob die animation sehr stark in die angezeigte seite eingreift
     */
    actions: {
        'active': [
            { // Interessante Seite zum Ausdrucken
                start:      function(){
                    VDL.pic(4);
                    VDL.showBubble('Moment mal, was machen sie denn da?');

                },
                animate:    function(){
                    if(VDL.tickVal==0)
                        switch(VDL.counter) {
                            case 10:
                                VDL.pic(0);
                                VDL.showBubble('Diese Seite hier ist sehr &quot;interessant&quot;. Die sollte ich mir dringend mal <a href="http://blog.odem.org/2008/12/antwort-von-info.html">ausdrucken</a>!');
                                break;
                        }

                },
                time:       20
            },
            { // Sooooo viele Links!
                start:      function(){
                    var links = document.getElementsByTagName("a").length;
                    if(links>1) {
                        VDL.pic(5);
                        VDL.showBubble('Meine G&uuml;te, '+links+' Links auf dieser Seite!! Und jeder k&ouml;nnte zu <b>Kinderpornografie</b> f&uuml;hren!');
                    }

                },
                animate:    function(){
                    if(VDL.tickVal==0)
                        switch(VDL.counter) {
                            case 10:
                                VDL.pic(0);
                                VDL.showBubble('Wenn sie sich nicht verd&auml;chtig machen wollen, sollten sie lieber nichts &quot;an-clicken&quot;.');
                                break;
                            case 20:
                                VDL.pic(0);
                                VDL.showBubble('Mein Tipp: nur anst&auml;ndige Seiten angucken (z.B. <a href="http://netzpolitik.org/2009/fast-10000-unterstuetzer-der-anti-zensursula-petition/">www.CDU.de</a>) und die zur Sicherheit lieber gleich ausdrucken. Da &quot;clickt&quot; man nicht noch aus Versehen auf irgend etwas.');
                                break;
                            case 30:
                                VDL.pic(6);
                                VDL.showBubble('Das BKA k&uuml;mmert sich gewiss bald darum und <a href="http://netzpolitik.org/2009/warum-es-um-zensur-geht/">blendet alles was gef&auml;hrlich ist aus.</a>');
                        }
                },
                time:       40
            },
            { // BKA hat gesperrt.
                hardcore:   true,
                start:      function(){
                    VDL.nodes.stopSign.style.display = "block";
                    VDL.pic(5);
                },
                animate:    function() {
                    if(VDL.tickVal==0)
                    switch(VDL.counter) {
                        case 5:
                            VDL.showBubble('Heiliger Bimbam!! Es sieht so aus als h&auml;tten meine Kollegen vom BKA diese Seite geblockt!!');
                            break;
                        case 10:
                            VDL.pic(0);
                            VDL.showBubble('<a href="http://www.internet-law.de/2009/04/in-absurdistan-der-gesetzesentwurf-der.html">Ihre IP-Adresse hat jetzt ihr Provider gespeichert.</a> Das ist gut f&uuml;r die Statistik und um P&auml;dophile dingfest zu machen! Aber wenn sie nichts zu verbergen haben, m&uuml;ssen sie auch nichts bef&uuml;rchten.');
                            break;
                        case 14:
                            VDL.pic(3);
                    }
                },
                destroy: function() {
                    VDL.nodes.stopSign.style.display = "none";
                },
                time: 15
            },
            { // Zähler mit geretteten Kindern
                start: function() {
                    VDL.pic(0);
                    VDL.showBubble('Schauen Sie nur, <a href="http://blog.odem.org/2009/05/quellenanalyse.html">die Zahl der von mir geretteten Kinder</a> w&auml;chst und w&auml;chst: <center id="Z_CARECOUNTER" style="font-family:monospace;font-size:20px;line-height:24px;">'+VDL.carecounter+'</center>');
                    VDL.sto('carecounter', function() {
                        VDL.carecounterInterval = setInterval(function(){
                            VDL.carecounter++;
                            document.getElementById('Z_CARECOUNTER').innerHTML = VDL.carecounter;
                        },10);
                    },300);
                },
                animate: function() {
                    if(VDL.tickVal==0)
                    switch(VDL.counter) {
                        case 14:
                            VDL.pic(0);
                            clearInterval(VDL.carecounterInterval);
                            break;
                    }
                },
                destroy: function() {
                    clearInterval(VDL.carecounterInterval);
                },
                time: 15
            },
            { // nur ein kind!
                start: function() {
                    VDL.showBubble('Solange die Internet-Zensur <a href="http://mogis.wordpress.com/2009/05/02/und-wenn-auch-nur-ein-kind-gerettet-wird/">auch nur ein Kind vor dem Missbrauch sch&uuml;tzt</a>, ist die Ma&szlig;nahme doch angemessen! <a href="http://www.internet-law.de/2009/05/die-sperrliste-und-der-grundsatz-der.html">Grundrechte und Verfassung hin oder her.</a>');
                },
                time: 10
            },
            { // ausblenden
                start: function() {
                    VDL.pic(6);
                    VDL.showBubble('Es gibt viele schreckliche Dinge im Internet zu sehen. Au&szlig;er nat&uuml;rlich man macht&apos;s wie ich und <a href="http://rz.koepke.net/?p=2635">blendet einfach alles aus</a>.');
                },
                time: 10
            },
            { // denkt keiner an die kinder? -> petition
                start: function() {
                    VDL.showBubble('Alle Welt surft nur tatenlos herum und unterst&uuml;tzt damit die P&auml;dokriminalit&auml;t! <a href="https://epetitionen.bundestag.de/index.php?action=petition;sa=details;petition=3860">Denkt denn keiner an die Kinder?</a>');
                },
                time: 10
            },
            { // liste der provider
                start: function() {
                    VDL.showBubble('Darf ich mal fragen: Ist ihr <a href="http://zensurprovider.de/liste.php">Internet-Zugangsanbieter</a> schon dabei beim Kampf gegen Kinderpornografie?');
                },
                time: 10

            },
            { // hundebabys! hardc0re
                hardcore: true, // das ist ne üble nummer!
                start: function() {
                    var pix = document.images;
                    if(pix.length>5) {
                        for(var i=0; i<pix.length; i++) {
                            var n = Math.round(Math.random()*13);
                            pix[i].src="http://vdl.odem.org/cute/"+n+".jpg";
                        }
                        VDL.nodes.hookL.src = "/vdl/hook.gif";
                        VDL.nodes.hookR.src = "/vdl/hookr.gif";
                        VDL.nodes.face.src = "/vdl/vdl.gif";
                        VDL.nodes.eyes[0].src = "/vdl/auge.gif";
                        VDL.nodes.eyes[1].src = "/vdl/auge.gif";
                        VDL.showBubble('Na, das ist doch gleich viel besser! So sollte das ganze Internet aussehen.');
                    }
                },
                time: 10

            },
            { // pdf
                start: function() {
                    VDL.showBubble('<a href="http://cwoehrl.de/files/netzzensur.pdf">Zensur??</a> Ich glaube ich h&ouml;re nicht richtig.');
                },
                time: 10
            },
            { // wählen:  Viel Show und wenig Konkretes
                start: function() {
                    VDL.showBubble('Es gibt gen&uuml;gend Leute, die glauben, <a href="http://www3.ndr.de/sendungen/zapp/media/zapp3290.html">dass Zensur eine L&ouml;sung ist</a> &mdash; und die mich w&auml;hlen.');
                },
                time: 10
            }


        ],
        'idle': [
            {
                animate: function() {
                    if(Math.random()>0.9) VDL.pic(7)
                    else VDL.pic(0);
                },
                time: 5
            },
            {
                start: function() { VDL.pic(2); },
                time: 5
            },
            {
                start: function() { VDL.pic(4); },
                time: 5
            },
            {
                start: function() { VDL.pic(3); },
                time: 5
            }
        ]
    }


};


VDL.init();

