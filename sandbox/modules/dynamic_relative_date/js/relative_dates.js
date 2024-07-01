(function (Drupal, drupalSettings) {
  Drupal.behaviors.relativeDates = {
    attach: function (context) {

      const lang = drupalSettings.path.currentLanguage || 'en'

      /**
       * @param {{label: String, seconds: Number}[]} intervals
       */
      const intervals = [
        { label: 'second', seconds: 1 },
        { label: 'minute', seconds: 60 },
        { label: 'hour', seconds: 3600 },
        { label: 'day', seconds: 86400 },
        { label: 'week', seconds: 604800 },
        { label: 'month', seconds: 2592000 },
        { label: 'year', seconds: 31536000 },
      ];

      Array.from(context.querySelectorAll('time.dynamic-relative-time')).forEach(function (date) {
        function updateRelativeItem() {
          let seconds = Math.floor(new Date().getTime() - new Date(date.getAttribute('datetime')).getTime()) / 1000

          let intervalSelected = null
          for (let interval of intervals) {
            if (Math.abs(seconds) < interval.seconds) {
              break
            }
            intervalSelected = interval
          }

          const count = Math.round(seconds / intervalSelected.seconds)
          const rtf = new Intl.RelativeTimeFormat(lang, { numeric: 'auto' })
          date.textContent = rtf.format(-count, intervalSelected.label)

          let nextTick = seconds % intervalSelected.seconds
          if (nextTick === 0) {
            nextTick = intervalSelected.seconds
          } else if (nextTick > 2147483647) {
            nextTick = 2147483647
          }

          setTimeout(() => {
            if (date.parentNode) {
              requestAnimationFrame(updateRelativeItem)
            }
          }, nextTick * 1000);
        }

        updateRelativeItem()
      })
    }
  }
})(Drupal, drupalSettings)
