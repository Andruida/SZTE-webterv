function enableEdit() {
    $(".profileData input").attr("readonly", false)
    $(".profileData textarea").attr("readonly", false)
    $(".profileData .picture *").show()
    $(".profileData .buttons input[type=\"button\"]").hide()
    $(".profileData .buttons input[type=\"submit\"]").show()
}