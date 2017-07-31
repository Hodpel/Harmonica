(function() {   
    tinymce.create('tinymce.plugins.emoji', { //注意这里有个 myadvert   
        init : function(ed, url) {   
            ed.addButton('emoji', { //注意这一行有一个 myadvert   
                title : 'Emoji',   
                image : url+'/biggrin.png', //注意图片的路径 url是当前js的路径   
                onclick : function() {   
    $('button').addClass('OwO');
                }   
            });   
        },   
        createControl : function(n, cm) {   
            return null;   
        },   
    });   
    tinymce.PluginManager.add('emoji', tinymce.plugins.emoji); //注意这里有两个 myadvert   
})();