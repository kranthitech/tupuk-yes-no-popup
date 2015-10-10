function defineTupukEvents() {
    //page load
    if (window.addEventListener) {
        window.addEventListener('load', emitPageLoaded, false); //W3C
    } else {
        window.attachEvent('onload', emitPageLoaded); //IE
    }

    function emitPageLoaded() {
        emitOnce('tupuk_page_loaded')
    }

    document.addEventListener('tupuk_page_loaded', function() {
        //define other events after the page load event
        //timeouts after 5,10,30,60 seconds
        var delay_times = [5, 10, 30, 60]

        delay_times.forEach(function(d) {
            setTimeout(function() {
                emitOnce('tupuk_elapsed_' + d)
            }, d * 1000)
        })

        //emit scrolled to bottom
        tupuk_listen(window, 'scroll', function() {
            if ((window.innerHeight + window.scrollY) >= getDocHeight() - 100) {
                // you're at the bottom of the page
                emitOnce('tupuk_scroll_bottom')
            }
        })
    })

    //emit tupuk_page_exit event
    tupuk_listen(document, 'mouseout', function(e) {
        e = e ? e : window.event;
        var from = e.relatedTarget || e.toElement;
        if ((!from || from.nodeName == "HTML") && (!e.clientY || (e.clientY <= 0))) {

            emitOnce('tupuk_page_exit')
        }
    })



    function emitOnce(eventName) {
        //only emit if this event was not already emitted
        if (!tupuk_events_emitted[eventName]) {
            var event; // The custom event that will be created
            if (document.createEvent) {
                event = document.createEvent("HTMLEvents");
                event.initEvent(eventName, true, true);
            } else {
                event = document.createEventObject();
                event.eventType = eventName;
            }

            event.eventName = eventName;

            if (document.createEvent) {
                document.dispatchEvent(event);
            } else {
                document.fireEvent("on" + event.eventType, event);
            }
            tupuk_events_emitted[eventName] = true
            console.log('Emitted event - ' + eventName)
        }

    }

    function getDocHeight() {
        var D = document;
        return Math.max(
            D.body.scrollHeight, D.documentElement.scrollHeight,
            D.body.offsetHeight, D.documentElement.offsetHeight,
            D.body.clientHeight, D.documentElement.clientHeight
        );
    }

    //setup the actual popup event based on the selected trigger
    console.log('tupuk_trigger- ' + tupuk_trigger)
    tupuk_listen(document, tupuk_trigger, function() {
        tupuk_show_popup()
    })

    var close_elements = document.getElementsByClassName('yeloni-close-button')
    for (var i = 0; i < close_elements.length; i++) {
        close_elements[i].addEventListener('click', function() {
            tupuk_hide_popup()
        })
    }

    function tupuk_listen(obj, evt, fn) {
        //some browsers support addEventListener, and some use attachEvent
        if (obj.addEventListener) {
            obj.addEventListener(evt, fn, false);
        } else if (obj.attachEvent) {
            obj.attachEvent("on" + evt, fn);
        }
    }

    function tupuk_show_popup() {
        if(document.getElementById("tupuk-sample-widget-container")){
            document.getElementById("tupuk-sample-widget-container").style.display = 'block'
        }
        
    }

    function tupuk_hide_popup() {
        if(document.getElementById("tupuk-sample-widget-container")){
            document.getElementById("tupuk-sample-widget-container").style.display = 'none'
        }
    }
}



//this is to ensure that even if the user uses multiple tupuk plugins, 
//the event emitting happens only once
if (typeof tupuk_events_defined === 'undefined') {
    var tupuk_events_defined = false
    var tupuk_events_emitted = {}
    defineTupukEvents()
    tupuk_events_defined = true
}