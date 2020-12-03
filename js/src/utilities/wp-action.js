const post = async (action, data) => new Promise((resolve, reject) => {
    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type : 'post',
        dataType : 'json',
        data : { action, ...data },
        success: function(response) {
            resolve(response.data);
        }
    });
});

export {
    post,
};


