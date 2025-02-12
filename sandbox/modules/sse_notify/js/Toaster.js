export default class Toaster {
  #container
  #template

  constructor () {
    this.#container = this.createContainer()
    this.#template = this.createToast()

    this.#container.addEventListener("click", this.closeNotification.bind(this))
    window.addEventListener("node", this.addItem.bind(this))
  }

  createContainer () {
    const notificationContainer = document.createElement('div')
    notificationContainer.classList.add('notification-container')
    window.document.body.insertAdjacentElement("afterend", notificationContainer)
    return notificationContainer
  }

  createToast () {
    const template = document.createElement('template')
    template.innerHTML = `
    <div class="messages messages--status messages-list__item" role="status">
      <div class="messages__header">
        <h2 class="messages__title">
          Node updated
        </h2>
        <button class="messages__close">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289Z" fill="currentColor"></path></svg>
        </button>
      </div>
      <div class="messages__content">
        Le contenu '<em class="placeholder"><a href="/node/3">Basic Page 2</a></em>', de type '<span class="node_type">Page de base</span>', a été mis à jour par <em class="node_updater_user">admin</em>.
      </div>
    </div>
    `
    return template
  }

  addItem (e) {
    switch (e.detail.action) {
      case 'update':
        let notification = this.#template.content.cloneNode(true)
        notification.querySelector('.messages__title').textContent = 'Node updated'
        notification.querySelector('.placeholder a').href = 'node/' + e.detail.id
        notification.querySelector('.placeholder a').textContent = e.detail.data.title
        notification.querySelector('.node_type').textContent = e.detail.data.type
        notification.querySelector('.node_updater_user').textContent = e.detail.data.username
        this.#container.appendChild(notification)
        break
    }
  }

  closeNotification (e) {
    if (e.target.closest('.messages__close')) {
      let parent = e.target.closest('.messages')
      parent.classList.add('messages--hidden')
      setTimeout(() => parent.remove(), 300)
    }
  }
}
