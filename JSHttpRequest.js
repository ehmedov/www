/**
 * JSHttpRequest: JavaScript DHTML data loader.
 * (C) 2005 Dmitry Koterov, http://forum.dklab.ru/users/DmitryKoterov/
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * See http://www.gnu.org/copyleft/lesser.html
 *
 * Do not remove this comment if you want to use script!
 * Не удаляйте данный комментарий, если вы хотите использовать скрипт!
 *
 * @author Dmitry Koterov 
 * @version 1.13
 */

function JSHttpRequest() {}
(function() { // local-scope variables
  var count       = 0;
  var pending     = {};
  var cache       = {};
  var spanReuse   = null;
  
  // Uncomment if you want to switch on <SCRIPT> reusing.
  // But be carefull: seems FireFox does not work with reusing correctly
  // (long delay on fast data reloading via existed <SCRIPT>).
  //spanReuse   = [];

  // Called by server script on data load.
  JSHttpRequest.dataReady = function(id, text, js) {
    var undef;
    var th = pending[id];
    if (th) {
      if (th.caching) cache[th.hash] = [text, js];
      th._dataReady(text, js);
    } else if (typeof(th) != typeof(undef)) {
      alert("ScriptLoader: unknown pending id: "+id);
    }
  }
  
  JSHttpRequest.prototype = {
    // Standard properties.
    onreadystatechange: null,
    readyState: 0,
    responseText: null,
    responseXML: null,
    status: 200,
    statusText: "OK",
    // Additional properties.
    responseJS: null, 
    caching: false,
    SID: null,
    // Internals.
    _span: null,
    _id: null,
      
    abort: function() { with (this) {
      readyState = 0;
      if (onreadystatechange) onreadystatechange();
      _cleanupScript();
      delete pending[_id];
    }},
      
    open: function(method, url, asyncFlag, username, password) {
      if ((""+method).toLowerCase() != 'get') {
        alert('Only GET method is supported!');
        return false;
      }
      this.url = url;
      return true;
    },
    
    send: function(content) {
      var id = count++;
      var query = [];
      if (content instanceof Object) {
        for (var k in content) {
          query[query.length] = escape(k) + "=" + escape(content[k]);
        }
      } else {
        query = [content];
      }
      var qs = query.join('&');
      query = id + ':' + (this.SID || '') + ':' + qs;
      var href = this.url + (this.url.indexOf('?')>=0? '&' : '?') + query;
      var hash = this.url + '?' + qs;
      this.hash = hash;
      if (this.caching && cache[hash]) {
        var c = cache[hash];
        this._dataReady(c[0], c[1]);
        return false;
      }
      this._obtainScript(id, href);
      return true;
    },

    getAllResponseHeaders: function() {
      return '';
    },
      
    getResponseHeader: function(label) {
      return '';
    },

    setRequestHeader: function(label, value) {
    },
    
    //
    // Internal functions.
    //

    _dataReady: function(text, js) { with (this) {
      if (text !== null || js !== null) {
        readyState = 4;
        responseText = responseXML = text;
        responseJS = js;
      } else {
        readyState = 0;
        responseText = responseXML = responseJS = null;
      }
      if (onreadystatechange) onreadystatechange();
      _cleanupScript();
    }},

    _obtainScript: function(id, href) { with (document) {
      var span = null;
      // Oh shit! Damned stupid fucked Opera 7.23 does not allow to create SCRIPT 
      // element over createElement (in HEAD or BODY section or in nested SPAN - 
      // no matter): it is created deadly, and does not respons on href assignment.
      // So - always create SPAN.
      if (spanReuse == null || !spanReuse.length) {
        span = body.appendChild(createElement("SPAN"));
        span.style.display = 'none';
        span.innerHTML = 'Text for stupid IE.<s'+'cript></' + 'script>';
        //span.innerHTML = 'Text for stupid IE.<s'+'cript language="JavaScript" src="'+href+'"></' + 'script>';
      } else {
        span = spanReuse[spanReuse.length-1];
        spanReuse[spanReuse.length-1] = null;
        spanReuse.length--;
      }
      pending[id] = this;
      setTimeout(function() {
        var s = span.getElementsByTagName("script")[0];
        s.language = "JavaScript";
        if (s.setAttribute) s.setAttribute('src', href); else s.src = href;
      }, 10);
      this._id = id;
      this._span = span;
    }},

    _cleanupScript: function() {
      var span = this._span;
      if (span) {
        this._span = null;
        setTimeout(function() {
          if (spanReuse != null) {
            spanReuse[spanReuse.length] = span;
          } else {
            // without setTimeout - crash in IE 5.0!
            span.parentNode.removeChild(span);
          }
        }, 50);
      }
      //window.status = document.body.childNodes.length + " - " + (spanReuse? spanReuse.length : 'no span reusing')
      return false;
    }
  }
})();
