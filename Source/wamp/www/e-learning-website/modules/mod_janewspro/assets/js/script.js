var requesting = false;
var jausersettingajax = null;
var JANEWSPRO = new Class({
	
	/**
	 * show user setting form.
	 */
    showForm: function (parent) {
        // looking for container which contain setting form.
        var container = parent.getElement('.ja-usersetting-options');
       
        if (container.offsetHeight <= 0) {
        	$$('.ja-usersetting-options').each(function(el){
        		if(el.offsetHeight>0){
        			this.hideElement(el);
        		}
        	}.bind(this));
            this.showElement(container, container.getElement('form.ja-usersetting-form').offsetHeight);
        } else {
            this.hideElement(container);
        }
        return false;
    },
    
	_bindingAndprocessingEventForm: function (parent){
    	var forms = parent.getElements('.ja-usersetting form');
    	    	
    	if(forms.length>0){
    		forms.each(function (form){
    	        // catch exeption
    	        if ($defined(form) == false) {
    	            alert("Could not found the form setting for this module, please try to check again");
    	            return;
    	        }
    	        
    	        // checkbox: click chooise all
    	        if (form.checkall != null) {
    	        	var checkboxs = form.getElements('input.checkbox');
    	            $(form.checkall).addEvent('click', function () {
    	                var doCheck = this.checked;
    	                checkboxs.each(function (elm) {
    	                    elm.checked = doCheck;    	                   
    	                }.bind(this));
    	            });
    	            
    	            checkboxs.each(function (elm) {
	                    elm.addEvent('click', function(){
	                    	if(!this.checked){
	                    		 $(form.checkall).checked = false;	                    		 
	                    	}
	                    	else{
	                    		var doCheck = true;
	                    		checkboxs.each(function (el) {
	                    			if(!el.checked) doCheck = false;
	                    		});
	                    		$(form.checkall).checked = doCheck;
	                    	}
	                    });
	                    
	                }.bind(this));
    	        }
    	        
    	        // if click button cancel.
    	        form.getElement('input.ja-cancel').addEvent('click', function () {
    	            this.hideElement(form.getParent());
    	        }.bind(this));
    	        
    	        // if click button submit.
    	        var submit_bt = form.getElement('input.ja-submit');
    	        submit_bt.addEvent('click', function () {
    	        	submit_bt.disabled = true;
    	        	var url = location.href;
    	        	if(url.indexOf('#')>-1){
    	        		url = url.substr(0, url.indexOf('#'));
    	        	}
    	        	if(url.indexOf('?')>-1) url += '&';
    	        	else url += '?';
    	        	url += 'janajax=1&rand=' + (Math.random() * Math.random());
    	        	
    	        	if(requesting){
    	        		jausersettingajax.cancel();
    	        		requesting = false;
    	        	}		    	
    	        	requesting = true;
    	        	
    	        	jausersettingajax = new Ajax(url, {
    	                method: 'get',
    	                data: form.toQueryString(),
    	                onComplete: function (data) {
    	            		submit_bt.disabled = false;
    	            		requesting = false;            		
    	                   	parent.innerHTML = data;
    	                   	this._bindingAndprocessingEventForm(parent);
    	                   	
    	                   	/*tooltip*/
    	                   	var JTooltips = new Tips($$('#' + parent.id + ' .jahasTip'), { maxTitleChars: 50, fixed: false, className: 'tool-tip janews-tool'});

    	                }.bind(this),
    	                
    	                onFailure: function () {
    	                	submit_bt.disabled = false;
    	                	requesting = false;
    	                    alert('fail request');
    	                }
    	            }).request();
    	        }.bind(this));
    			
    		}.bind(this));
    	}		
	},
	
	/**
	 *  Show or hide element
	 */
    showElement: function (obj, height) {
        if (!obj.fx) {
            obj.fx = new Fx.Style(obj, 'height');
        }
        obj.fx.start(height);
    },
    
    hideElement: function (obj) {
        obj.maxHeight = obj.offsetHeight;
        if (!obj.fx) {
            obj.fx = new Fx.Style(obj, 'height');
        }
        obj.fx.start(0);
    }
});