/** https://codepen.io/giana/pen/OrpdLK */
class Collapse {
  constructor(container, options = {}) {
    let defaults = {
      accordion: false,
      initClass: 'collapse-init',
      activeClass: 'panel-active',
      heightClass: 'collapse-reading-height',
    }

    this.settings = Object.assign({}, defaults, options);

    this._container = container;
    this._panels = container.querySelectorAll("details");

    this.events = {
      openingPanel: new CustomEvent('openingPanel'),
      openedPanel: new CustomEvent('openedPanel'),
      closingPanel: new CustomEvent('closingPanel'),
      closedPanel: new CustomEvent('closedPanel'),
    };
  }

  // Sets height of panel content
  _setPanelHeight( panel ) {
    let contents = panel.querySelector("summary + *");

    contents.style.height = contents.scrollHeight + "px";
  }

  // Removes height of panel content
  _removePanelHeight( panel ) {
    let contents = panel.querySelector("summary + *");

    contents.style.height = null;
  }

  // Open panel
  open(panel) {
    panel.dispatchEvent( this.events.openingPanel );

    panel.open = true;
  }

  // Add height and active class, this triggers opening animation
  _afterOpen(panel) {
    this._setPanelHeight(panel);
    panel.classList.add(this.settings.activeClass);
  }

  // Remove height on animation end since it's no longer needed
  _endOpen(panel) {
    panel.dispatchEvent( this.events.openedPanel );

    this._removePanelHeight(panel);
  }

  // Close panel, not toggling the actual [open] attr!
  close(panel) {
    panel.dispatchEvent( this.events.closingPanel );
    this._afterClose(panel);
  }

  // Set height, wait a beat, then remove height to trigger closing animation
  _afterClose(panel) {
    this._setPanelHeight(panel);

    setTimeout(() => {
      panel.classList.remove(this.settings.activeClass);
      this._removePanelHeight(panel);
    }, 100); //help, this is buggy and hacky
  }

  // Actually closes panel once animation finishes
  _endClose(panel) {
    panel.dispatchEvent( this.events.closedPanel );

    panel.open = false;
  }

  // Toggles panel... just in case anyone needs this
  toggle(panel) {
    panel.open ? this.close(panel) : this.open(panel);
  }

  // Accordion closes all panels except the current passed panel
  openSinglePanel(panel) {
    this._panels.forEach((element) => {
      if (panel == element && !panel.open) {
        this.open(element);
      } else {
        this.close(element);
      }
    });
  }

  // Opens all panels just because
  openAll() {
    this._panels.forEach((element) => {
      this.open(element);
    });
  }

  // Closes all panels just in case
  closeAll() {
    this._panels.forEach((element) => {
      this.close(element);
    });
  }

  // Scroll to panel
  scrollTo(panel) {
    const y = panel.getBoundingClientRect().top + window.pageYOffset - 10;
    window.scrollTo({top: y, behavior: 'smooth'});
  }

  // Now put it all together
  _attachEvents() {
    this._panels.forEach(panel => {
      let toggler = panel.querySelector("summary");
      let contents = panel.querySelector("summary + *");

      // On panel open
      panel.addEventListener("toggle", e => {
        let isReadingHeight = panel.classList.contains(this.settings.heightClass);

        if (panel.open && !isReadingHeight) {
          this._afterOpen(panel);
          //this.scrollTo(panel);
        }
      });

      toggler.addEventListener("click", e => {
        // If accordion, stop default toggle behavior
        if (this.settings.accordion) {
          this.openSinglePanel(panel);
          e.preventDefault();
        }

        // On attempting close, stop default close behavior to substitute our own
        else if (panel.open) {
          this.close(panel);
          e.preventDefault();
        }

        // On open, proceed as normal (see toggle listener above)
      });

      /*
        transitionend fires once for each animated property,
        but we want it to fire once for each click.
        So let's make sure to watch only a single property
        Note this makes complex animations with multiple transition-durations impossible
        Sorry
      */
      let propToWatch = '';

      // On panel finishing open/close animation
      contents.addEventListener("transitionend", (e) => {
        // Ignore transitions from child elements
        if(e.target !== contents) {
          return;
        }

        // Set property to watch on first fire
        if ( !propToWatch ) propToWatch = e.propertyName;

        // If watched property matches currently animating property
        if ( e.propertyName == propToWatch ) {
          let wasOpened = panel.classList.contains(this.settings.activeClass);
          wasOpened ? this._endOpen(panel) : this._endClose(panel);
        }
      });
    });
  }

  init() {
    // Attach functionality
    this._attachEvents();

    // If accordion, open the first panel
    /*if (this.settings.accordion) {
      this.openSinglePanel(this._panels[0]);
    }*/

    // For styling purposes
    this._container.classList.add(this.settings.initClass);

    return this;
  }
}

let makeMePretty = document.querySelector(".collapse");
let accordion = new Collapse(makeMePretty, { accordion: true }).init();

// hoisthoistupwego I'm stuck on a machine with IE11
function miscPolyfillsForIE() {
  // NodeList.forEach() polyfill
  // https://developer.mozilla.org/en-US/docs/Web/API/NodeList/forEach#Browser_Compatibility
  if (window.NodeList && !NodeList.prototype.forEach) {
    NodeList.prototype.forEach = Array.prototype.forEach;
  }

  // Object.assign() polyfill
  // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/assign
  "function"!=typeof Object.assign&&Object.defineProperty(Object,"assign",{value:function(e,t){"use strict";if(null==e)throw new TypeError("Cannot convert undefined or null to object");for(var n=Object(e),r=1;r<arguments.length;r++){var o=arguments[r];if(null!=o)for(var c in o)Object.prototype.hasOwnProperty.call(o,c)&&(n[c]=o[c])}return n},writable:!0,configurable:!0});

  // CustomEvent polyfill
  // https://developer.mozilla.org/en-US/docs/Web/API/CustomEvent
  !function(){if("function"==typeof window.CustomEvent)return!1;function t(t,e){e=e||{bubbles:!1,cancelable:!1,detail:void 0};var n=document.createEvent("CustomEvent");return n.initCustomEvent(t,e.bubbles,e.cancelable,e.detail),n}t.prototype=window.Event.prototype,window.CustomEvent=t}();
}
