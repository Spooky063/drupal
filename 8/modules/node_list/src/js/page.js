function loadArticles() {
    return {
        items: [],
        isLoading: true,
        hasItems: false,
        search: "",
        selectedCategory: "",
        selectedTags: [],
        selectedOrder: "asc",
        selectAllTags: false,
        sortByKey: "created_at",
        sortByOrder: ["asc", "desc"],
        pageNumber: 0,
        sizePerPage: 4,
        total: "",

        async fetchData() {
            let response = await fetch('/api/articles')
            if (response.ok) {
                let data = await response.json()
                this.items = data.data
                this.hasItems = this.items.length > 0
                this.isLoading = false
            }
        },

        get filteredItems() {
            const start = this.pageNumber * this.sizePerPage,
                end = start + this.sizePerPage;

            if (
                this.search === ""
                && this.selectedCategory === ""
                && this.selectedTags.length === 0
                && this.selectedOrder === ""
            ) {
                return this.items.slice(start, end)
            }

            let filtered = this.items.filter((item) => {
                return item.title.toLowerCase().includes(this.search.toLowerCase())
            })

            if (this.selectedCategory !== "") {
                filtered = filtered.filter((item) => {
                    return item.category.find((value) => value === this.selectedCategory)
                })
            }

            if (this.selectedTags.length !== 0) {
                this.selectAllTags =
                    this.selectedTags.length === this.tagOptionList().length
                filtered = filtered.filter((item) => {
                    return this.selectedTags.find((tag) => item.tags.includes(tag))
                })
            }

            if (this.selectedOrder !== "") {
                filtered.sort((a, b) => {
                    if (this.selectedOrder === "asc") {
                        return new Date(b[this.sortByKey]) - new Date(a[this.sortByKey])
                    } else {
                        return new Date(a[this.sortByKey]) - new Date(b[this.sortByKey])
                    }
                })
            }

            this.total = filtered.length

            return [...new Set(filtered)].slice(start, end)
        },

        // Filters
        get categoryOptions() {
            let options = this.items.map((item) => item.category)
            return [...new Set(options.flat(1))]
        },

        get tagOptions() {
            return this.tagOptionList()
        },

        tagOptionList() {
            let options = this.items.map((item) => item.tags)
            return [...new Set(options.flat(1))]
        },

        toggleAllTags() {
            this.selectAllTags = !this.selectAllTags
            if (this.selectAllTags === true) {
                this.selectedTags = this.tagOptionList()
            } else {
                this.selectedTags = []
            }
        },

        // Pagination
        pages() {
            return Array.from({
                length: Math.ceil(this.total / this.sizePerPage),
            })
        },

        nextPage() {
            this.pageNumber++
            this.goTop()
        },

        prevPage() {
            this.pageNumber--
            this.goTop()
        },

        pageCount() {
            return Math.ceil(this.total / this.sizePerPage)
        },

        startResults() {
            return this.pageNumber * this.sizePerPage + 1
        },

        endResults() {
            let resultsOnPage = (this.pageNumber + 1) * this.sizePerPage

            if (resultsOnPage <= this.total) {
                return resultsOnPage
            }

            return this.total
        },

        viewPage(index) {
            this.pageNumber = index
            this.goTop()
        },

        goTop() {
            document.getElementById('content_page').scrollIntoView({
                behavior: "smooth",
            });
        }
    }
}
