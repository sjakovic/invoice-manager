const getEntityFromRow = function(e) {
    return $(e.target).parents('tr').data('entity');
};

export { getEntityFromRow };