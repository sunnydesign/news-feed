'use strict';

class Header extends React.Component {
    render() {
        return (
            <h1 className="text-center">Городская жизнь: новости</h1>
        )
    }
}

class Articles extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            items: [],
            meta: [],
            links: [],
            scroll: true
        }
    }
    isReceiveDataAllowed() {
         return this.state.scroll && this.state.links.next !== undefined
    }
    handleScroll() {
        const lastItem = document.querySelector(".article-container > tr:last-child")
        const bounding = lastItem.getBoundingClientRect()

        if(bounding.top < window.innerHeight && this.isReceiveDataAllowed()) {
            this.getData()
        }
    }
    getData() {
        const url = this.state.items.length ? this.state.links.next.href : '/api/v1/articles?category=1'
        const params = {
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Methods': 'GET',
            }
        }
        this.setState({scroll: false})
        axios
            .get(url, params)
            .then(res => {
                this.setState({
                    items: this.state.items.concat(res.data.items),
                    meta: res.data._meta,
                    links: res.data._links,
                    scroll: true
                })
            })
            .catch(error => {
                console.log(error);
            })
    }
    componentDidMount() {
        this.getData()
        window.addEventListener("scroll", e => {
            this.handleScroll(e);
        })
    }
    render() {
        return (
            <MaterialUI.TableContainer component={MaterialUI.Paper}>
                <MaterialUI.Table aria-label="simple table">
                    <MaterialUI.TableHead>
                        <MaterialUI.TableRow>
                            <MaterialUI.TableCell>#</MaterialUI.TableCell>
                            <MaterialUI.TableCell>Title</MaterialUI.TableCell>
                            <MaterialUI.TableCell>Content</MaterialUI.TableCell>
                        </MaterialUI.TableRow>
                    </MaterialUI.TableHead>
                    <MaterialUI.TableBody className="article-container">
                        {this.state.items.map((row) => (
                            <MaterialUI.TableRow key={row.id}>
                                <MaterialUI.TableCell>{row.id}</MaterialUI.TableCell>
                                <MaterialUI.TableCell style={{ width: 200 }}>{row.title}</MaterialUI.TableCell>
                                <MaterialUI.TableCell dangerouslySetInnerHTML={{ __html: row.content }}></MaterialUI.TableCell>
                            </MaterialUI.TableRow>
                        ))}
                    </MaterialUI.TableBody>
                </MaterialUI.Table>
            </MaterialUI.TableContainer>
        )
    }
}

class App extends React.Component {
    render() {
        return (
            <div>
                <Header />
                <Articles />
            </div>
        )
    }
}

ReactDOM.render(
    <App />,
    document.getElementById('root')
);