(function() {
    tinymce.PluginManager.requireLangPack("contentbox");
    tinymce.create("tinymce.plugins.ContentboxPlugin", {
        init: function(a, b) {
            a.addCommand("mceContentbox", function() {
                a.windowManager.open({
                    file: b + "/dialog.htm",
                    width: 640 + parseInt(a.getLang("example.delta_width", 0)),
                    height: 400 + parseInt(a.getLang("example.delta_height", 0)),
                    inline: 1
                }, {
                    plugin_url: b,
                    some_custom_arg: "custom arg"
                })
            });
            a.addButton("contentbox", {
                title: "Custome Content",
                cmd: "mceContentbox",
                image: b + "/img/thcl.png"
            });
            a.onNodeChange.add(function(d, c, e) {
                c.setActive("contentbox", e.nodeName == "IMG")
            })
        },
        createControl: function(b, a) {
            return null
        },
        getInfo: function() {
            return {
                longname: "Content box plugin",
                author: "MinhVQ",
                authorurl: "http://thuonghieucongluan.com.vn",
                infourl: "http://thuonghieucongluan.com.vn",
                version: "1.0"
            }
        }
    });
    tinymce.PluginManager.add("contentbox", tinymce.plugins.ContentboxPlugin)
})();