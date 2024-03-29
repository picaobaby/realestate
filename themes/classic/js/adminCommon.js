jQuery(function($) {
    $(document).ajaxSend(function(){
        $("#loading").show();
        /*$("#overlay-content").show();
        $("#loading-blocks").show();*/
    }).ajaxComplete(function(){
        $("#loading").hide();
        /*$("#overlay-content").hide();
        $("#loading-blocks").hide();*/
    });

    /*$("a.fancy").magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        mainClass: 'mfp-img-mobile'
    });*/
    
    $(".form-disable-button-after-submit").submit(function () {
        $(".submit-button").attr("disabled", true);
        //$(".submit-button").before("<img src='" + INDICATOR + "' alt='Loading' border='0' style='text-decoration: none; vertical-align: middle; margin-right: 5px; height: 24px; width: 24px;' />");
        return true;
    });
});

function focusSubmit(elem) {
    elem.keypress(function(e) {
        if(e.which == 13) {
            $(this).blur();
            $("#btnleft").focus().click();
        }
    });
}

function ajaxSetStatus(elem, id){
	$.ajax({
		url: $(elem).attr('href'),
		success: function(res){
			$('#'+id).yiiGridView.update(id);

            if (res == 'reload') {
                location.reload();
            }
		}
	});
}

function ajaxMoveRequest(url, tableId){
	$.ajax({
		url: url,
		data: {ajax:1},
		method: "get",
		success: function(){
			$("#"+tableId).yiiGridView.update(tableId);
		}
	});
}

(function ($) {
    $.fn.extend({
        //pass the options variable to the function
        confirmModal: function (options) {
            var html = '<div class="modal" id="confirmContainer"><div class="modal-header"><a class="close" data-dismiss="modal">×</a>' +
            '<h3>#Heading#</h3></div><div class="modal-body">' +
            '#Body#</div><div class="modal-footer">' +
            '<a href="javascript: void(0);" class="btn btn-primary" id="confirmYesBtn">#Confirm#</a>' +
            '<a href="javascript: void(0);" class="btn" data-dismiss="modal">#Close#</a></div></div>';

            var defaults = {
                heading: 'Please confirm',
                body:'Body contents',
				confirmButton: 'Да',
				closeButton: 'Нет',
                callback : null
            };

            var options = $.extend(defaults, options);
            html = html.replace('#Heading#',options.heading).replace('#Body#',options.body).replace('#Confirm#',options.confirmButton).replace('#Close#',options.closeButton);
            $(this).html(html);
            $(this).modal('show');
            var context = $(this);
            $('#confirmYesBtn',this).click(function(){
                if(options.callback!=null)
                    options.callback();
                $(context).modal('hide');
            });
        }
    });

})(jQuery);

var scriptLoaded = [];

function loadScript(url, reload, async, defer) {
    reload = reload || true;
    async = async || false;
    defer = defer || false;

    if(typeof scriptLoaded[url] == 'undefined' || reload){
        var script = document.createElement("script");
        if (async) {
            script.async = true;
        }
        if (defer) {
            script.defer = true;
        }
        script.type = "text/javascript";
        script.src = url;
        document.body.appendChild(script);

        scriptLoaded[url] = 1;
    }
}

function addCSSRule(sheet, selector, rules){
    //Backward searching of the selector matching cssRules
    var index=sheet.cssRules.length-1;
    for(var i=index; i>0; i--){
      var current_style = sheet.cssRules[i];
      if(current_style.selectorText === selector){
            //Append the new rules to the current content of the cssRule;
            rules=current_style.style.cssText + rules;
            sheet.deleteRule(i);
            index=i;
      }
    }
    if(sheet.insertRule){
      sheet.insertRule(selector + "{" + rules + "}", index);
    }
    else{
      sheet.addRule(selector, rules, index);
    }
    return sheet.cssRules[index].cssText;
}