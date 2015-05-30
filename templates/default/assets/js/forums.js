$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    $(".textarea").wysihtml5(
        {
            "font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": false, //Button which allows you to edit the generated HTML. Default false
            "link": true, //Button to insert a link. Default true
            "image": true, //Button to insert an image. Default true,
            "color": false, //Button to change color of font
            "blockquote": true, //Blockquote
            "fa": true,
            "size": "sm" //default: none, other options are xs, sm, lg
        }
    );
});