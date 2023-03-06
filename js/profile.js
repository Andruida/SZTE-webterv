function enableEdit() {
    $(".profileData input").attr("readonly", false)
    $(".profileData textarea").attr("readonly", false)
    $(".profileData .picture *").css("visibility", "visible")
    $("#buttons input[type=\"button\"]").hide()
    $("#buttons input[type=\"submit\"]").show()
}
function removeProfile() {
    if (confirm("Biztos törölni akarod?")) {
        $.post("backend/removeProfile.php")
        .done(function(data) {window.location="index.php"})
    }
}