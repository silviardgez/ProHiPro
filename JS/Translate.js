function translatePage(language = "es") {
    if(language === "es" || language === "gl" || language === "en") {
        setCookie("language-selected", language);
    }
    var lang=language, // Check the Browser language
        translate; // Container of all translations

    // Call translations json file and populate translate variable
    $.getJSON("../Locates/translations.json", function(texts) {
        translate=texts;
        // Translate all the element with data-translate
        translateElement("data-translate", translate, lang);
        // Translate all placeholders
        translateElement("placeholder", translate, lang);
    });
}

function translateElement(elementName, translate, lang) {
    $("[" + elementName + "]").each(function() {
        let text= $(this).attr(elementName), // Save the Text into the variable
            numbers= text.match(/\d+/g),
            element=  $('[' + elementName + '="'+text+'"]'),
            postHTML;

        if (numbers != null && numbers>1)
            text= text.replace(numbers, '%n');

        if (translate[text]!==undefined) { // Check if exist the text in translation.json

            if (translate[text][lang]!==undefined) { // Check if exist the text in the language
                postHTML= translate[text][lang];
            } else { // If not exist the lang, show the text in primary
                postHTML= text;
            }

            if (numbers != null && numbers>1)
                postHTML= postHTML.replace('%n', numbers);

            if (elementName === "placeholder") {
                $('[' + elementName + '="'+text+'"]').attr("placeholder",postHTML);
            } else {
                element.html(postHTML);
            }

        } else {
            $('[' + elementName + '="'+text+'"]').html("ERR").css({'color':'red','font-weight':'bold'});
        }
    });
}
