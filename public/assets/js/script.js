Gamma = {
    
    Init: function() {
        
        cLog("Gamma.Init called. Initiating Gamma");
        
        $('#logo').click(function() {
            if($('#quick_search_form').is(':hidden')) {
                // advanced menu shown
                cLog("Collapsing advanced menu.");
                $('#menu').animate({height: '-=' + $('#advanced_search').height()});
                $('#quick_search_form').fadeIn('slow');
            } else {
                cLog("Expanding advanced menu.");
                $('#menu').animate({height: '+=' + $('#advanced_search').height()});
                $('#quick_search_form').fadeOut('slow');
            }
        });
        cLog("EVENT: Menu onClick hooked.");
        
        Gamma.InitQuickSearch();
        Gamma.AdvancedSearch.Init();
        /*$.pjax({
            url: 'api/movies',
            container: '#movies',
            fragment: '#movies'
        });*/
    },
    
    InitQuickSearch: function() {
        cLog("Gamma.InitQuickSearch called.");
        
        var qs = $('#quick_search_input');
        
        qs.focus(function() {
            if ($(this).val().toLowerCase() == Gamma.Lang.QuickSearch.toLowerCase()) {
                $(this).val('');
            }
        }).blur(function() {
            if ($(this).val() == '') {
                $(this).val(Gamma.Lang.QuickSearch);
            }
        });
        
        cLog("EVENT: QuickSearch onFocus hooked.");
    }
}

Gamma.AdvancedSearch = {
    Init: function() {
        cLog("Gamma.AdvancedSearch.Init called.");
        
        Gamma.AdvancedSearch.InitCheckboxes();
        Gamma.AdvancedSearch.InitSearchBars();
    },
    
    InitCheckboxes: function() {
        cLog("Gamma.InitCheckboxes called.");
        $('.ticbox').click(function() {
            var val = $(this).parent().attr('class');
            var cb = $('#' + $(this).attr('target'));
            var vals = cb.val();
            if(val == 'setting-include') {
                if (vals.search($(this).next().html()) > -1) {
                    vals = vals.replace("inc" + $(this).next().html(), "exc" + $(this).next().html());
                } else {
                    vals += "|exc"+$(this).next().html();
                }
                $(this).parent().attr('class','setting-exclude');
            } else if (val == 'setting-exclude') {
                vals = vals.replace("exc" + $(this).next().html(), "");
                if (vals == "|" || vals == "") {
                    vals = 0;
                }
                $(this).parent().attr('class','setting-none');
            } else {
                if (vals == '0') {
                    vals = "inc" + $(this).next().html();
                } else if (vals.search($(this).next().html()) > -1) {
                    vals = vals.replace($(this).next().html(), "inc" + $(this).next().html());
                } else {
                    vals += "|inc"+$(this).next().html();
                }
                $(this).parent().attr('class','setting-include');
            }
            cb.val(vals);
        });
        cLog("EVENT: Checkboxes onClick hooked.");
    },
    
    InitSearchBars: function() {
        cLog("Gamma.AdvancedSearch.InitSearchBars called.");
        
        var st = $('#search_titles_input');
        var sp = $('#search_people_input');
        
        st.focus(function() {
            if ($(this).val().toLowerCase() == Gamma.Lang.SearchTitle.toLowerCase()) {
                $(this).val('');
            }
        }).blur(function() {
            if ($(this).val() == '') {
                $(this).val(Gamma.Lang.SearchTitle);
            }
        });
        
        sp.focus(function() {
            if ($(this).val().toLowerCase() == Gamma.Lang.SearchPeople.toLowerCase()) {
                $(this).val('');
            }
        }).blur(function() {
            if ($(this).val() == '') {
                $(this).val(Gamma.Lang.SearchPeople);
            }
        });
        
        cLog("EVENT: Search bars onFocus hooked.");
    }
}

Gamma.Lang = {
    QuickSearch: "Quick Search",
    SearchTitle: "Search title",
    SearchPeople: "Search people"
}