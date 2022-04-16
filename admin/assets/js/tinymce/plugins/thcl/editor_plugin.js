(function() {
    tinymce.PluginManager.requireLangPack("thcl");
    tinymce.create("tinymce.plugins.ThclPlugin", {
        init: function(a, b) {
            a.addCommand("mceThcl", function() {
                a.windowManager.open({
                    file: b + "/dialog.htm",
                    width: 600 + parseInt(a.getLang("thcl.delta_width", 0)),
                    height: 380 + parseInt(a.getLang("thcl.delta_height", 0)),
                    inline: 1
                }, {
                    plugin_url: b,
                    some_custom_arg: "custom arg"
                })
            });
            a.addButton("thcl", {
                title: "Nội dung tùy chỉnh",
                cmd: "mceThcl",
                image: b + "/img/example.gif"
            });
            a.onNodeChange.add(function(d, c, e) {
                c.setActive("thcl", e.nodeName == "IMG")
            })
        },
        createControl: function(b, a) {
            return null
        },
        getInfo: function() {
            return {
                longname: "THCL plugin",
                author: "MinhVQ",
                authorurl: "http://thuonghieucongluan.com.vn",
                infourl: "http://thuonghieucongluan.com.vn",
                version: "1.0"
            }
        }
    });
    tinymce.PluginManager.add("thcl", tinymce.plugins.ThclPlugin)
})();