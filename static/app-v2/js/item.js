(function ($, win) {

    function loadItems() {
        $.get("http://localhost:8001/admin/api/d/menuitem/read", {}, function(result) {
            console.log(result);
          
        })
    }

    win["item"] = {
        "loadItems": loadItems
    }

})(jQuery, window);