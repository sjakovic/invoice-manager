const crud = {
    create: function (url, data) {
        return $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
        });
    },
    update: function (url, data) {
        data.append('_method', 'PUT');
        return $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
        });
    },
    delete: function (url) {
        return $.ajax({
            url: url,
            method: 'DELETE',
            dataType: 'json',
        });
    },
};

export {crud};