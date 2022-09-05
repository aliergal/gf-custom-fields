jQuery(document).ready(function($){

    // Parse the URL
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\[").replace(/[\]]/, "\]");
        var regex = new RegExp("[\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    //Get the URL parameters
    var utm_source = getParameterByName('utm_source');
    var utm_medium = getParameterByName('utm_medium');
    var utm_campaign = getParameterByName('utm_campaign');
    var utm_content = getParameterByName('utm_content');
    var utm_term = getParameterByName('utm_term');

    //Set them in the local storage
    if(utm_source) Cookies.set('utm_source', utm_source, { expires: 30 })
    if(utm_medium) Cookies.set('utm_medium', utm_medium, { expires: 30 });
    if(utm_campaign) Cookies.set('utm_campaign', utm_campaign, { expires: 30 });
    if(utm_content) Cookies.set('utm_content', utm_content, { expires: 30 });
    if(utm_term) Cookies.set('utm_term', utm_term, { expires: 30 });


    function setutm(utm_param, utm_val){
        if (Cookies.get(utm_param) != undefined) {
            jQuery('.'+utm_param).val('');
            jQuery('.'+utm_param).val(Cookies.get(utm_param));
            console.log(utm_param + " set from cookies");
        }else{
            if(utm_val){
                jQuery('.'+utm_param).val('');
                jQuery('.'+utm_param).val(utm_val);
                console.log(utm_param + " set from parameters");
            }else{
                console.log(utm_param + " not set");
            }
        }
    }

    setutm('utm_source',utm_source);
    setutm('utm_medium',utm_medium);
    setutm('utm_campaign',utm_campaign);
    setutm('utm_content',utm_content);
    setutm('utm_term',utm_term);

   

});