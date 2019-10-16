$(document).on("click", ".add", function() {
    var memberForm = $(this).parent();
    var cloneMemberForm =  memberForm.clone(true);
    cloneMemberForm.find("input.search_name").val("");
    cloneMemberForm.insertAfter(memberForm);
});
$(document).on("click", ".del", function() {
    var memberForm = $(this).parent();
    if (memberForm.parent().children().length > 1) {
        memberForm.remove();
    }
});
