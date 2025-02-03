import Toaster from './Toaster.js'

(function () {
  const userId = drupalSettings.user.uid
  const topics = drupalSettings.sse_notify.topics

  const url = new URL(drupalSettings.sse_notify.hub)
  topics.forEach(topic => url.searchParams.append('topic', topic))

  if (!("EventSource" in window)) {
    console.error("This browser does not support EventSource.")
  }

  const eventSource = new EventSource(url, { withCredentials: true })
  eventSource.onmessage = e => {
    const data = JSON.parse(e.data)
    if (data.userId != userId) {
      emitEvent(data)
    }
  }

  function emitEvent ({ type, action, id, data }) {
    window.dispatchEvent(
      new CustomEvent(type, {
        detail: {
          action,
          id,
          data,
        }
      })
    )
  }

  new Toaster()
})();
