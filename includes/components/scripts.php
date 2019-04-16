<? $core->loadScript("jquery.min.js") ?>
<? $core->loadScript("async.js") ?>
<? $core->loadScript("init.js") ?>
<? $core->loadScript("prism.js") ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.9.0/showdown.min.js"></script>
<script>

var editor = document.getElementById("editor");
var preview = document.getElementById("preview");
var invisibles = document.getElementById("invisibles");
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
    processInvisibles(editor.innerHTML);
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
    // processInvisibles(content);
    // console.log(content);
    processMarkdown(content);
}

function processInvisibles(content) {
    // content = content.replace(" ", "<div id=\"space-dot\">·</div>");
    // markdown.value = content;
    // /\S+/
    //overlay.innerHTML = content;
    // console.log();


    // ovc = ovc.replace(/[\040]/gm, '•');
    // ovc = ovc.replace(/[\n]/gm, '¬\n');
    // ovc = ovc.replace(/[^•¬\n]/gm, ' ');


    content = content.replace(/[\040]/gm, '•');
    content = content.replace(/[\n]/gm, '¬\n');
    content = content.replace(/[^•¬\n]/gm, ' ');


    content = content.replace(/[•]/gm, '<span class="spc">•</span>');
    content = content.replace(/[¬]/gm, '<span class="spc">¬</span>');

    content = content.replace(/((.*?)\n*[^\n]$)/gm, '<div class="line">$1</div>');
    if (content.endsWith("\n")) {
        content += '<div class="line"></div>';
    }
    content = content.replace(/\n/gm, '');




    // console.log(ovc);
    invisibles.innerHTML = content;
}

function processMarkdown(content) {



    var result = converter.makeHtml(content);
    processInvisibles(content);
    preview.innerHTML = result;
}






var isSyncingLeftScroll = false;
var isSyncingRightScroll = false;

editor.onscroll = function() {
    if (!isSyncingLeftScroll) {
        isSyncingRightScroll = true;
        preview.scrollTop = this.scrollTop;
        invisibles.scrollTop = this.scrollTop;

        preview.scrollLeft = this.scrollLeft;
        invisibles.scrollLeft = this.scrollLeft;
    }
    isSyncingLeftScroll = false;
}

preview.onscroll = function() {
    if (!isSyncingRightScroll) {
        isSyncingLeftScroll = true;
        editor.scrollTop = this.scrollTop;
        invisibles.scrollTop = this.scrollTop;

        editor.scrollLeft = this.scrollLeft;
        invisibles.scrollLeft = this.scrollLeft;
    }
    isSyncingRightScroll = false;
}

</script>
