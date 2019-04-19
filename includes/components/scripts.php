<? $core->loadScript("jquery.min.js") ?>
<? $core->loadScript("async.js") ?>
<? $core->loadScript("init.js") ?>
<? $core->loadScript("prism.js") ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.9.0/showdown.min.js"></script>
<script>

var editor = document.getElementById("editor");
var preview = document.getElementById("preview");
// var invisibles = document.getElementById("invisibles");
var converter = new showdown.Converter();
converter.setOption("simplifiedAutoLink", true);
converter.setOption("literalMidWordUnderscores", true);
converter.setOption("strikethrough", true);
converter.setOption("tables", true);
converter.setOption("tasklists", true);



converter.setOption("smoothLivePreview", true);
converter.setOption("smartIndentationFix", true);
converter.setOption("disableForced4SpacesIndentedSublists", true);
converter.setOption("simpleLineBreaks", true);
converter.setOption("emoji", true);
converter.setOption("parseImgDimensions", true);
converter.setOption("tables", true);
converter.setOption("tables", true);



editor.addEventListener("input", renderMarkdown);
editor.addEventListener("change", renderMarkdown);
// markdown.addEventListener("click", highlightLine);
window.addEventListener("load", init);

function init() {
    // processInvisibles(editor.innerHTML);
    var content = converter.makeHtml(editor.textContent);
    preview.innerHTML = content;
}

// function highlightLine() {
//     var line = markdown.value.substr(0, markdown.selectionStart).split("\n").length - 1;
//     var lines = document.querySelectorAll("#invisibles .line");
//     lines.forEach(function(element, index) {
//         if (index != line) {
//             element.classList.remove("active");
//         }
//         else {
//             element.classList.add("active");
//         }
//     });
//
//
//     // lines[line].classList.add("active");
// }

function renderMarkdown() {
    var content = editor.value;

    content = content.replace(/<code.*?(lang=\"([^\"]*)\")?>\n(.*?)<\/code>/sm, `<div class=\"code-block\">
                <div class=\"lang\">$2</div>
                <pre class=\"language-$2 line-numbers\"><code class=\"language-$2\">$3</code></pre>
            </div>`);

    // processInvisibles(content);
    // console.log(content);
    processMarkdown(content);
    Prism.highlightAll();
}



function processMarkdown(content) {



    var result = converter.makeHtml(content);
    // processInvisibles(content);
    preview.innerHTML = result;
}






var isSyncingLeftScroll = false;
var isSyncingRightScroll = false;

editor.onscroll = function() {
    if (!isSyncingLeftScroll) {
        isSyncingRightScroll = true;
        preview.scrollTop = this.scrollTop;

        preview.scrollLeft = this.scrollLeft;
    }
    isSyncingLeftScroll = false;
}

preview.onscroll = function() {
    if (!isSyncingRightScroll) {
        isSyncingLeftScroll = true;
        editor.scrollTop = this.scrollTop;

        editor.scrollLeft = this.scrollLeft;
    }
    isSyncingRightScroll = false;
}

</script>
