jQuery('.custom_upload_image_button').on('click',function() {
    var $this = jQuery(this);
    var formfield = $this.siblings('.custom_upload_image');
    var preview = $this.siblings('.custom_preview_image');

    tb_show('', 'media-upload.php?type=image&TB_iframe=true');
    window.send_to_editor = function(html) {
        var imgurl = jQuery(html).attr('src');
        var classes = jQuery(html).attr('class');

        var id = classes.replace(/(.*?)wp-image-/, '');

        formfield.val(id);
        preview.attr('src', imgurl);
        tb_remove();
    };

    return false;
});

jQuery('.custom_clear_image_button').on('click',function() {
    var $parent = jQuery(this).parent();
    var defaultImage = $parent.siblings('.custom_default_image').text();

    $parent.siblings('.custom_upload_image').val('');
    $parent.siblings('.custom_preview_image').attr('src', defaultImage);

    return false;
});

jQuery('#items_is_wine').on('change',function() {
    if(this.checked){
        jQuery('.normal-price').stop().hide();
        jQuery('.wine-price').stop().show();
    } else {
        jQuery('.normal-price').stop().show();
        jQuery('.wine-price').stop().hide();
    }
});

// Modified http://goessner.net/download/prj/jsonxml/
function json2xml(o,tab){
    var toXml = function(v,name,ind){
        var xml = '';
        if(v instanceof Array){
            for(var i = 0,n = v.length; i < n; i++)
                xml += ind + toXml(v[i],name,ind + '\t');
        }
        else if(typeof(v) == 'object'){
            var hasChild = false;
            xml += ind + '[' + name;
            for(var m in v){
                if(m.charAt(0) == '@')
                    xml += ' ' + m.substr(1) + '="' + v[m].toString() + '"';
                else
                    hasChild = true;
            }
            xml += hasChild ? ']' : '][/' + name + ']';
            if(hasChild){
                for(var m in v){
                    if(m == '#text')
                        xml += v[m];
                    else if(m == '#cdata')
                        xml += '<![CDATA[' + v[m] + ']]>';
                    else if(m.charAt(0) != '@')
                        xml += toXml(v[m],m,ind + '\t');
                }
                xml += (xml.charAt(xml.length - 1) == '\n' ? ind : '') + '[/' + name + ']';
            }
        }
        else {
            xml += ind + '[' + name + ']' + v.toString() + '[/' + name + ']';
        }
        return xml;
    },xml = '';
    for(var m in o)
        xml += toXml(o[m],m,'');
    return tab ? xml.replace(/\t/g,tab) : xml.replace(/\t/g,''); //xml.replace(/\t|\n/g,'')
}

// https://davidwalsh.name/convert-xml-json
function xmlToJson(xml) {
	var obj = {};
	if (xml.nodeType == 3) {
		obj = xml.nodeValue;
	}

	if (xml.hasChildNodes()) {
		for(var i = 0; i < xml.childNodes.length; i++) {
			var item = xml.childNodes.item(i);
			var nodeName = item.nodeName;

			if (typeof(obj[nodeName]) == 'undefined') {
				obj[nodeName] = xmlToJson(item);
			} else {
				if (typeof(obj[nodeName].push) == 'undefined') {
					var old = obj[nodeName];
					obj[nodeName] = [];
					obj[nodeName].push(old);
				}

				obj[nodeName].push(xmlToJson(item));
			}
		}
	}
	return obj;
}

(function($){
    var $editor = $('#menus_fixed_price');
    var $box = $('#menu_editor_box').find('.inside');
    var content = $editor.val();
    var tree = {};

    if(content){
        var xmlString = content.replace(/\[/g, '<').replace(/\]/g, '>');
        var xml = $.parseXML(xmlString);
        tree = xmlToJson(xml);
    } else {
        tree = {
            menu: {
                menu_title: {},
                menu_special: {
                    menu_category: []
                }
            }
        };
    }
    
    // Ensure that the menu_category level is an array even if there's only 1
    if(tree.menu && tree.menu.menu_special && tree.menu.menu_special.menu_category && !Array.isArray(tree.menu.menu_special.menu_category)){
        tree.menu.menu_special.menu_category = [tree.menu.menu_special.menu_category];
    }

    console.log(JSON.stringify(tree, true, 4));

    render();

    function makeTitle(name,className,type,category){
        category = typeof category === 'undefined' ? -1 : category;
        return '<tr class="menu-section-' + className + '">' +
            '<td colspan="4"><h3>' + name +
            '<div class="button button-primary button-large pull-right" data-type="' + type + '" data-category="' + category + '" onclick="handleAddRow(event)">Add ' + type + '</div></h3>' +
            '</td></tr>';
    }

    function makeInput(name,label,value,type,displayButtons,description){
        value = value || '';
        var html = '<tr class="menu-input-row">';
        
        if(displayButtons){
            html += '<td class="col-buttons align-top"><div class="button button-secondary button-medium btn-up" data-direction="up" onclick="handleMoveItem(event,\'' + type + '\')">Up</div></td>';
        } else if (displayButtons !== null) {
            html += '<td class="col-buttons align-top"><div class="button button-secondary button-medium btn-down" data-direction="down" onclick="handleMoveItem(event,\'' + type + '\')">Down</div></td>';
        } else {
            html += '<td></td>';
        }
        
        html += '<th><label for="ci-' + name + '">' + label + '</label></th>';
        html += '<td><input type="text" id="ci-' + name + '" name="' + name + '" value="' + decodeURIComponent(value) + '" onkeyup="handleInputChange(event)"/>';

        if(description){
            html += '<br/><span class="description">' + description + '</span>';
        }

        html += '</td>';
        if(displayButtons){
            html += '<td class="col-buttons single" rowspan="2"><div class="button button-danger button-large" onclick="handleDeleteItem(event,\'' + type + '\')">Delete</div></td>';
        }
        html += '</tr>';
        return html;
    }

    function makeTextarea(name,label,value,displayButtons,description){
        value = value || '';
        var html = '<tr>';

        if(displayButtons){
            html += '<td class="col-buttons align-top">' +
                '<div class="button button-secondary button-medium btn-up" data-direction="up" onclick="handleMoveItem(event,\'category\')">Up</div>' +
                '<div class="button button-secondary button-medium btn-down" data-direction="down" onclick="handleMoveItem(event,\'category\')">Down</div>' +
            '</td>';
        } else {
            html += '<td></td>';
        }

        html += '<th><label for="ci-' + name + '">' + label + '</label></th>';
        html += '<td><textarea rows="7" id="ci-' + name + '" name="' + name + '" onkeyup="handleInputChange(event)">' +  decodeURIComponent(value) + '</textarea>';

        if(description){
            html += '<br/><span class="description">' + description + '</span>';
        }

        html += '</td><td></td></tr>';
        return html;
    }

    window.handleAddRow = function(event){
        var target = event.target;
        var type = target.getAttribute('data-type');
        var category = target.getAttribute('data-category');

        switch(type){
            case 'item':
                tree.menu.menu_special.menu_category[category].menu_items.menu_item.push({
                    menu_item_title: {},
                    menu_item_description: {}
                });
                break;
            case 'category':
                tree.menu.menu_special.menu_category.push({
                    menu_category_title: {},
                    menu_category_description: {},
                    menu_items: {
                        menu_item: []
                    }
                });
                break;
        }

        render();

         if(type === 'item'){
            var targetCat = parseInt(category,10)+2;
            $('html, body').animate({scrollTop:($('.inside > .form-menu > tbody > tr').eq(targetCat).find('tr').last().offset().top)},1000);
        } else {
            $('html, body').animate({scrollTop:($('.form-menu').find('tr').last().offset().top)},1000);
        }
    };

    window.handleInputChange = function(event){
        var target = event.target;
        var value = target.value;
        var id = target.id.replace('ci-','').split('-');
        var name = id[0];
        var category = typeof id[1] === 'undefined' ? null : id[1];
        var item = typeof id[2] === 'undefined' ? null : id[2];

        console.log('--------------')
        console.log('modified',name,category,item)
        console.log(value)
        console.log('--------------')

        switch(name){
            case 'menu_title':
                tree.menu.menu_title = {'#text': value};
                break;
            case 'menu_category_title':
            case 'menu_category_description':
                tree.menu.menu_special.menu_category[category][name] = {'#text': encodeURIComponent(value)};
                break;
            case 'menu_item_title':
            case 'menu_item_description':
                tree.menu.menu_special.menu_category[category].menu_items.menu_item[item][name] = {'#text': encodeURIComponent(value)};
                break;
        }

        console.log(JSON.stringify(tree, true, 4));
        console.log(json2xml(tree));
        $editor.html(json2xml(tree));
    };

    window.handleDeleteItem = function(event,type){
        console.log(type);
    };

    window.handleMoveItem = function(event,type){

    };

    function render(){
        var html = '<table class="form-table form-menu"><tbody>';
        html += makeTextarea('menu_title','Title',tree.menu.menu_title && tree.menu.menu_title['#text'] || '');
        html += makeTitle('Categories','categories','category');

        if(tree.menu.menu_special && tree.menu.menu_special.menu_category){
            tree.menu.menu_special.menu_category.forEach(function(menu_category,category_i){
                html += '<tr><td colspan="4"><table class="form-menu"><thead>';
                html += makeInput('menu_category_title-' + category_i,'Category Name',menu_category.menu_category_title['#text'],'category',null);
                html += makeTextarea('menu_category_description-' + category_i,'Category Description',menu_category.menu_category_description['#text'],true);
                html += '</thead><tbody>';

                if(menu_category.menu_items && menu_category.menu_items.menu_item){
                    // Ensure that the menu_item level is an array even if there's only 1
                    if(!Array.isArray(menu_category.menu_items.menu_item)){
                        menu_category.menu_items.menu_item = [menu_category.menu_items.menu_item];
                    }

                    html += makeTitle('Items','items','item',category_i);
                    menu_category.menu_items.menu_item.forEach(function(menu_item,item_i){
                        html += makeInput('menu_item_title-' + category_i + '-' + item_i,'Name',menu_item.menu_item_title['#text'],'item',true);
                        html += makeInput('menu_item_description-' + category_i + '-' + item_i,'Description',menu_item.menu_item_description['#text'],'item');
                    });
                }
                html += '</tbody></table></td></tr>';
            });
        }

        html += '</tbody></table>';
        $box.html(html);
    }
})(jQuery);
