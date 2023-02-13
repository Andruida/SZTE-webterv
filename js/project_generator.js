$(document).ready(() => {
    const params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
    });
    $("span[name='projectName']").text(params.projectName)
})