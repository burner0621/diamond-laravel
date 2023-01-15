<style>
    .chat-view-container {
        position: fixed;
        bottom: 50px;
        right: 50px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .chat-button {
        border-width: 0px;
        font-size: 40px;
        color: palegreen;
        background: transparent;
    }

    .chat-list {
        padding: 0;
        font-size: .8rem;
    }

    .chat-list li {
        margin-bottom: 10px;
        overflow: auto;
        color: #ffffff;
    }

    .chat-list .chat-img {
        float: left;
        width: 48px;
    }

    .chat-list .chat-img img {
        -webkit-border-radius: 50px;
        -moz-border-radius: 50px;
        border-radius: 50px;
        width: 100%;
    }

    .chat-list .chat-message {
        -webkit-border-radius: 50px;
        -moz-border-radius: 50px;
        border-radius: 50px;
        background: #5a99ee;
        display: inline-block;
        padding: 10px 20px;
        position: relative;
    }

    .chat-list .chat-message:before {
        content: "";
        position: absolute;
        top: 15px;
        width: 0;
        height: 0;
    }

    .chat-list .chat-message h5 {
        margin: 0 0 5px 0;
        font-weight: 600;
        line-height: 100%;
        font-size: .9rem;
    }

    .chat-list .chat-message p {
        line-height: 18px;
        margin: 0;
        padding: 0;
    }

    .chat-list .chat-body {
        margin-left: 20px;
        float: left;
        width: 70%;
    }

    .chat-list .in .chat-message:before {
        left: -12px;
        border-bottom: 20px solid transparent;
        border-right: 20px solid #5a99ee;
    }

    .chat-list .out .chat-img {
        float: right;
    }

    .chat-list .out .chat-body {
        float: right;
        margin-right: 20px;
        text-align: right;
    }

    .chat-list .out .chat-message {
        background: #fc6d4c;
    }

    .chat-list .out .chat-message:before {
        right: -12px;
        border-bottom: 20px solid transparent;
        border-left: 20px solid #fc6d4c;
    }

    .card .card-header:first-child {
        -webkit-border-radius: 0.3rem 0.3rem 0 0;
        -moz-border-radius: 0.3rem 0.3rem 0 0;
        border-radius: 0.3rem 0.3rem 0 0;
    }
    .card .card-header {
        background: #17202b;
        border: 0;
        font-size: 1rem;
        padding: .65rem 1rem;
        position: relative;
        font-weight: 600;
        color: #ffffff;
    }
</style>

<div class="chat-view-container">
    <div id="chat-view" class="collapse card">
        <div class="card-header">Chat</div>
        <div class="card-body height3">
            <ul class="chat-list">
                <li class="in">
                    <div class="chat-img">
                        <img alt="Avtar" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                    </div>
                    <div class="chat-body">
                        <div class="chat-message">
                            <h5>Jimmy Willams</h5>
                            <p>Raw denim heard of them tofu master cleanse</p>
                        </div>
                    </div>
                </li>
                <li class="out">
                    <div class="chat-img">
                        <img alt="Avtar" src="https://bootdey.com/img/Content/avatar/avatar6.png">
                    </div>
                    <div class="chat-body">
                        <div class="chat-message">
                            <h5>Serena</h5>
                            <p>Next level veard</p>
                        </div>
                    </div>
                </li>
                <li class="in">
                    <div class="chat-img">
                        <img alt="Avtar" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                    </div>
                    <div class="chat-body">
                        <div class="chat-message">
                            <h5 class="name">Jimmy Willams</h5>
                            <p>Will stumptown scenes coffee viral.</p>
                        </div>
                    </div>
                </li>
                <li class="out">
                    <div class="chat-img">
                        <img alt="Avtar" src="https://bootdey.com/img/Content/avatar/avatar6.png">
                    </div>
                    <div class="chat-body">
                        <div class="chat-message">
                            <h5>Serena</h5>
                            <p>Tofu master best deal</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <button class="chat-button" data-bs-toggle="collapse" data-bs-target="#chat-view"><i class="bi bi-chat-right-dots-fill"></i></button>
</div>