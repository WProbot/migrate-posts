//alert("SettingsPage.js here!");
const MigratePosts = {};
MigratePosts.actionRemoveItemFromPasswordsComponent = function(Url){
    jQuery.ajax({
        url: "/wp-json/migrate-posts/v1/remove-item-from-remote-passwords-component",
        data: {
            'Url': Url,
            '_wpnonce': wpApiSettings.nonce,
        },
        method: "POST",
        success: function(data) {
            console.log(data);
            return(data);
        },
        error: function(errorThrown) {
            fetchPostTitleResponse = JSON.stringify(errorThrown);
            console.log("error: ");
            console.log(errorThrown);
        }
    });
}

