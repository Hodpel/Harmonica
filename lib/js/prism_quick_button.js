(function (window, $) {
  'use strict';

  /**
   * Custom Trim function
   * @returns {string}
   */
  String.prototype.trim = function () {
    return this.replace(/^\s+|\s+$/g, '');
  };

  /**
   * Get language list from inline script
   */
  var langs=[{text:"Markup", value:"markup"},{text:"Css", value:"css"},{text:"Clike", value:"clike"},{text:"Javascript", value:"javascript"},{text:"Php", value:"php"},{text:"Ruby", value:"ruby"},{text:"Sql", value:"sql"},{text:"C", value:"c"},{text:"Abap", value:"abap"},{text:"Actionscript", value:"actionscript"},{text:"Ada", value:"ada"},{text:"Apacheconf", value:"apacheconf"},{text:"Apl", value:"apl"},{text:"Applescript", value:"applescript"},{text:"Asciidoc", value:"asciidoc"},{text:"Aspnet", value:"aspnet"},{text:"Autoit", value:"autoit"},{text:"Autohotkey", value:"autohotkey"},{text:"Bash", value:"bash"},{text:"Basic", value:"basic"},{text:"Batch", value:"batch"},{text:"Bison", value:"bison"},{text:"Brainfuck", value:"brainfuck"},{text:"Bro", value:"bro"},{text:"Csharp", value:"csharp"},{text:"Cpp", value:"cpp"},{text:"Coffeescript", value:"coffeescript"},{text:"Crystal", value:"crystal"},{text:"D", value:"d"},{text:"Dart", value:"dart"},{text:"Diff", value:"diff"},{text:"Django", value:"django"},{text:"Docker", value:"docker"},{text:"Eiffel", value:"eiffel"},{text:"Elixir", value:"elixir"},{text:"Erlang", value:"erlang"},{text:"Fsharp", value:"fsharp"},{text:"Fortran", value:"fortran"},{text:"Gherkin", value:"gherkin"},{text:"Git", value:"git"},{text:"Glsl", value:"glsl"},{text:"Go", value:"go"},{text:"Graphql", value:"graphql"},{text:"Groovy", value:"groovy"},{text:"Haml", value:"haml"},{text:"Handlebars", value:"handlebars"},{text:"Haskell", value:"haskell"},{text:"Haxe", value:"haxe"},{text:"Http", value:"http"},{text:"Icon", value:"icon"},{text:"Inform7", value:"inform7"},{text:"Ini", value:"ini"},{text:"J", value:"j"},{text:"Jade", value:"jade"},{text:"Java", value:"java"},{text:"Jolie", value:"jolie"},{text:"Json", value:"json"},{text:"Julia", value:"julia"},{text:"Keyman", value:"keyman"},{text:"Kotlin", value:"kotlin"},{text:"Latex", value:"latex"},{text:"Less", value:"less"},{text:"Livescript", value:"livescript"},{text:"Lolcode", value:"lolcode"},{text:"Lua", value:"lua"},{text:"Makefile", value:"makefile"},{text:"Markdown", value:"markdown"},{text:"Matlab", value:"matlab"},{text:"Mel", value:"mel"},{text:"Mizar", value:"mizar"},{text:"Monkey", value:"monkey"},{text:"Nasm", value:"nasm"},{text:"Nginx", value:"nginx"},{text:"Nim", value:"nim"},{text:"Nix", value:"nix"},{text:"Objectivec", value:"objectivec"},{text:"Ocaml", value:"ocaml"},{text:"Oz", value:"oz"},{text:"Parigp", value:"parigp"},{text:"Parser", value:"parser"},{text:"Pascal", value:"pascal"},{text:"Perl", value:"perl"},{text:"Powershell", value:"powershell"},{text:"Processing", value:"processing"},{text:"Prolog", value:"prolog"},{text:"Properties", value:"properties"},{text:"Protobuf", value:"protobuf"},{text:"Puppet", value:"puppet"},{text:"Pure", value:"pure"},{text:"Python", value:"python"},{text:"Q", value:"q"},{text:"Qore", value:"qore"},{text:"R", value:"r"},{text:"Jsx", value:"jsx"},{text:"Reason", value:"reason"},{text:"Rest", value:"rest"},{text:"Rip", value:"rip"},{text:"Roboconf", value:"roboconf"},{text:"Rust", value:"rust"},{text:"Sas", value:"sas"},{text:"Sass", value:"sass"},{text:"Scss", value:"scss"},{text:"Scala", value:"scala"},{text:"Scheme", value:"scheme"},{text:"Smalltalk", value:"smalltalk"},{text:"Smarty", value:"smarty"},{text:"Stylus", value:"stylus"},{text:"Swift", value:"swift"},{text:"Tcl", value:"tcl"},{text:"Textile", value:"textile"},{text:"Twig", value:"twig"},{text:"Typescript", value:"typescript"},{text:"Verilog", value:"verilog"},{text:"Vhdl", value:"vhdl"},{text:"Vim", value:"vim"},{text:"Wiki", value:"wiki"},{text:"Xojo", value:"xojo"},{text:"Yaml", value:"yaml"},];

  
  tinymce.PluginManager.add('prism', function (editor, url) {
    editor.addButton('prism', {
      title: 'Prism Assistant',
      text: 'Prism',
      type: false,
      icon: 'wp_code',
      onclick: function () {
        editor.windowManager.open({
          title: 'Prism Syntax Highlighter Assistant',
          width: 550,
          height: 450,
          body: [
            {
              type: 'listbox',
              name: 'language',
              label: 'Language* :',
              values: langs,
              value: langs[0].value
            },
            {
              type: 'checkbox',
              name: 'lineNumbers',
              label: 'Show line numbers:',
              checked: true
            },
            {
              type: 'textbox',
              name: 'lineNumStart',
              label: 'Start line number from:'
            },
            {
              type: 'textbox',
              name: 'code',
              label: 'Paste code*:',
              multiline: true,
              minHeight: 250,
              value: '',
              onclick: function (e) {
                $(e.target).css('border-color', '');
              }
            },
            {
              type: 'label',
              name: 'info',
              label: 'Note:',
              text: 'These options works only if enabled on Plugin Option Page.',
              style: 'font-size:smaller'
            }
          ],
          onsubmit: function (e) {
            var lineNum = '',
                lineNumStart = '',
                highlight = '',
                code = e.data.code.trim();

            // Code is required
            if (code === '') {
              var windowId = this._id;
              var inputs = $('#' + windowId + '-body').find('.mce-formitem textarea');
              $(inputs.get(0)).css('border-color', 'red').focus();
              return false;
            }
            if (e.data.lineNumbers) {
              lineNum = ' class="line-numbers" ';
            }
            if (e.data.lineNumStart && e.data.lineNumbers) {
              lineNumStart = ' data-start="' + e.data.lineNumStart + '" ';
            }
            if (e.data.highLight) {
              highlight = ' data-line="' + e.data.highLight + '" ';
            }
            var language = e.data.language;
            // HTML entities encode
            code = code.replace(/</g, '&lt;').replace(/>/g, '&gt;');
            editor.insertContent('<pre' + highlight + lineNum + lineNumStart + '><code class="language-' + language + '">' + code + '</code></pre>');
          }
        });
      }
    });
  });
})(window, jQuery);