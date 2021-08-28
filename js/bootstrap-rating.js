!function(t,i){"use strict";var n=5;function s(s,o){var a;this.$input=t(s),this.$rating=t("<span></span>").css({cursor:"default"}).insertBefore(this.$input),this.options=((a=t.extend({},this.$input.data(),o)).start=parseInt(a.start,10),a.start=isNaN(a.start)?i:a.start,a.stop=parseInt(a.stop,10),a.stop=isNaN(a.stop)?a.start+n||i:a.stop,a.step=parseInt(a.step,10)||i,a.fractions=Math.abs(parseInt(a.fractions,10))||i,a.scale=Math.abs(parseInt(a.scale,10))||i,(a=t.extend({},t.fn.rating.defaults,a)).filledSelected=a.filledSelected||a.filled,a),this._init()}s.prototype={_init:function(){for(var n=this,s=this.$input,o=this.$rating,a=function(t){return function(n){s.prop("disabled")||s.prop("readonly")||s.data("readonly")!==i||t.call(this,n)}},e=1;e<=this._rateToIndex(this.options.stop);e++){var r=t('<div class="rating-symbol"></div>').css({display:"inline-block",position:"relative"});t('<div class="rating-symbol-background '+this.options.empty+'"></div>').appendTo(r),t('<div class="rating-symbol-foreground"></div>').append('<span class="'+this.options.filled+'"></span>').css({display:"inline-block",position:"absolute",overflow:"hidden",left:0,right:0,width:0}).appendTo(r),o.append(r),this.options.extendSymbol.call(r,this._indexToRate(e))}this._updateRate(s.val()),s.on("change",function(){n._updateRate(t(this).val())});var l,p=function(i){var s=t(i.currentTarget),o=Math.abs((i.pageX||i.originalEvent.touches[0].pageX)-(("rtl"===s.css("direction")&&s.width())+s.offset().left));return o=o>0?o:.1*n.options.scale,s.index()+o/s.width()};o.on("mousedown touchstart",".rating-symbol",a(function(t){s.val(n._indexToRate(p(t))).change()})).on("mousemove touchmove",".rating-symbol",a(function(s){var o=n._roundToFraction(p(s));o!==l&&(l!==i&&t(this).trigger("rating.rateleave"),l=o,t(this).trigger("rating.rateenter",[n._indexToRate(l)])),n._fillUntil(o)})).on("mouseleave touchend",".rating-symbol",a(function(){l=i,t(this).trigger("rating.rateleave"),n._fillUntil(n._rateToIndex(parseFloat(s.val())))}))},_fillUntil:function(t){var i=this.$rating,n=Math.floor(t);i.find(".rating-symbol-background").css("visibility","visible").slice(0,n).css("visibility","hidden");var s=i.find(".rating-symbol-foreground");s.width(0),s.slice(0,n).width("auto").find("span").attr("class",this.options.filled),s.eq(t%1?n:n-1).find("span").attr("class",this.options.filledSelected),s.eq(n).width(t%1*100+"%")},_indexToRate:function(t){return this.options.start+Math.floor(t)*this.options.step+this.options.step*this._roundToFraction(t%1)},_rateToIndex:function(t){return(t-this.options.start)/this.options.step},_roundToFraction:function(t){var i=Math.ceil(t%1*this.options.fractions)/this.options.fractions,n=Math.pow(10,this.options.scale);return Math.floor(t)+Math.floor(i*n)/n},_contains:function(t){var i=this.options.step>0?this.options.start:this.options.stop,n=this.options.step>0?this.options.stop:this.options.start;return i<=t&&t<=n},_updateRate:function(t){var i=parseFloat(t);this._contains(i)?(this._fillUntil(this._rateToIndex(i)),this.$input.val(i)):""===t&&(this._fillUntil(0),this.$input.val(""))},rate:function(t){if(t===i)return this.$input.val();this._updateRate(t)}},t.fn.rating=function(n){var o,a=Array.prototype.slice.call(arguments,1);return this.each(function(){var i=t(this),e=i.data("rating");e||i.data("rating",e=new s(this,n)),"string"==typeof n&&"_"!==n[0]&&(o=e[n].apply(e,a))}),o!==i?o:this},t.fn.rating.defaults={filled:"glyphicon glyphicon-star",filledSelected:i,empty:"glyphicon glyphicon-star-empty",start:0,stop:n,step:1,fractions:1,scale:3,extendSymbol:function(t){}},t(function(){t("input.rating").rating()})}(jQuery);