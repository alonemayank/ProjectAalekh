

"use strict";
        
        $(document).ready(function() {
            
           
            
//==========================DYNAMIC CONTENT LOADING==============//
                    
            //Default Behvior
                    $("#dudhsagar").hide(); 
                    $("#kodachadri").hide(); 
                    $("#kasol").hide(); 
                    $("#kudle").fadeIn();

                    $("#dudhsagarfalls").removeClass("selected");
                    $("#kodachadrihills").removeClass("selected");
                    $("#kasolvalley").removeClass("selected");
                    $("#kudlebeach").addClass("selected");

                        //MAP 1
                var mapCanvas1 = document.getElementById('map');
                var mapOptions1 = {
                  center: new google.maps.LatLng(14.527652, 74.315857),
                  zoom: 14,
                  scrollwheel: false,
                  mapTypeId: google.maps.MapTypeId.HYBRID
                }
                var map1 = new google.maps.Map(mapCanvas1, mapOptions1)
            
            
            //Event listners
            $("#kudlebeach").on("click", function(e){
                    $("#dudhsagar").hide(); 
                    $("#kodachadri").hide(); 
                    $("#kasol").hide(); 
                    $("#kudle").fadeIn();

                    $("#dudhsagarfalls").removeClass("selected");
                    $("#kodachadrihills").removeClass("selected");
                    $("#kasolvalley").removeClass("selected");
                    $("#kudlebeach").addClass("selected");
            
                } );
            
            $("#dudhsagarfalls").on("click", function(e){
			
                    $("#dudhsagar").fadeIn();
                    $("#kodachadri").hide(); 
                    $("#kasol").hide(); 
                    $("#kudle").hide();

                    $("#kudlebeach").removeClass("selected");
                    $("#kodachadrihills").removeClass("selected");
                    $("#kasolvalley").removeClass("selected");
                    $("#dudhsagarfalls").addClass("selected");
                 //MAP3
                var mapCanvas3 = document.getElementById('map3');
                var mapOptions3 = {
                  center: new google.maps.LatLng(15.314765, 74.314082),
                  zoom: 14,
                     scrollwheel: false,
                  mapTypeId: google.maps.MapTypeId.HYBRID
                }
                var map3 = new google.maps.Map(mapCanvas3, mapOptions3)
                });
            
            $("#kodachadrihills").on("click", function(e){
                    $("#dudhsagar").hide(); 
                    $("#kodachadri").fadeIn(); 
                    $("#kasol").hide(); 
                    $("#kudle").hide();

                    $("#dudhsagarfalls").removeClass("selected");
                    $("#kodachadrihills").addClass("selected");
                    $("#kasolvalley").removeClass("selected");
                    $("#kudlebeach").removeClass("selected");
                //MAP2
                var mapCanvas2 = document.getElementById('map2');
                var mapOptions2 = {
                  center: new google.maps.LatLng(13.861956, 74.875032),
                  zoom: 15,
                  scrollwheel: false,
                  mapTypeId: google.maps.MapTypeId.HYBRID
                }
                var map2 = new google.maps.Map(mapCanvas2, mapOptions2)
            
                } );
            
            $("#kasolvalley").on("click", function(e){
                    $("#dudhsagar").hide(); 
                    $("#kodachadri").hide(); 
                    $("#kasol").fadeIn(); 
                    $("#kudle").hide();

                    $("#dudhsagarfalls").removeClass("selected");
                    $("#kodachadrihills").removeClass("selected");
                    $("#kasolvalley").addClass("selected");
                    $("#kudlebeach").removeClass("selected");
                
    //MAP4
        var mapCanvas4 = document.getElementById('map4');
        var mapOptions4 = {
          center: new google.maps.LatLng(32.010005, 77.314133),
          zoom: 16,
             scrollwheel: false,
          mapTypeId: google.maps.MapTypeId.HYBRID
        }
        var map4 = new google.maps.Map(mapCanvas4, mapOptions4)
       
            
                } );
            
        });
    
