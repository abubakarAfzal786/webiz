<template>
    <fragment>
        <div class="data chat-list-wrap col-lg-5">
            <div class="data-bg">
                <div class="chat-list">
                    <div class="scroll-list">
                        <ul v-model="tickets">
                            <li
                                v-for="(ticket, key) in tickets"
                                :data-id="ticket.id"
                                :data-key="key"
                                :class="{ 'active' : ticket.id === active_ticket.id}"
                                @click="getMessagesOnClick"
                            >
                                <div class="member-data">
                                    <div class="member-img">
                                        <img
                                            :src="ticket.member.avatar_url ? ticket.member.avatar_url : '/images/default-user.png'"
                                            alt="">
                                    </div>
                                    <div class="text">
                                        <div class="name">
                                            <p>{{ ticket.member.name }} <span class="">Ticket {{ ticket.id }}</span>
                                                <i class="icon-empty"></i>
                                                <!--<i class="icon-star"></i>-->
                                            </p>
                                            <p class="time">12:23</p>
                                        </div>
                                        <div class="message">
                                            <p>{{ ticket.last_message }}</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="close-chat-list d-lg-none">
                    <button type="button" class="main-btn yellow-blank">Close</button>
                </div>
            </div>
        </div>

        <div class="data col-lg-7 col-md-12">
            <div class="data-bg">
                <div class="active-chat">
                    <div class="member-data" v-if="active_ticket.id">
                        <div class="open-chat-list d-lg-none">
                            <button type="button"><span class="icon-menu"></span></button>
                        </div>
                        <div class="member-img">
                            <img
                                :src="active_ticket.member.avatar_url ? active_ticket.member.avatar_url : '/images/default-user.png'"
                                alt="">
                        </div>
                        <div class="text">
                            <div class="name">
                                <p>{{ active_ticket.member.name }} <span class="">Ticket {{ active_ticket.id }}</span>
                                </p>
                                <p><i class="icon-empty"></i></p>
                            </div>
                        </div>
                        <div class="btn">
                            <button type="button">Close Request</button>
                        </div>
                    </div>
                    <div class="chat-message">
                        <div class="chat-scroll">
                            <div class="chat-wrap" v-model="messages">
                                <div class="message-text"
                                     v-for="message in messages"
                                     :data-id="message.id"
                                     :class="{
                                         'received': message.is_member === true,
                                         'sent': message.is_member === false
                                     }"
                                >
                                    <div class="content">
                                        <div class="name">
                                            <p>{{ message.is_member ? active_ticket.member.name : 'You' }}</p>
                                        </div>
                                        <div class="text">
                                            <p>{{ message.text }}</p>
                                        </div>
                                        <div class="status">
                                            <p>{{ message.created_at | chatDate }} <span class="icon-seen"></span></p>
                                        </div>
                                    </div>
                                    <div class="user">
                                        <img
                                            :src="active_ticket.member.avatar_url ? active_ticket.member.avatar_url : '/images/default-user.png'"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-control" v-if="active_ticket.id">
                        <label>
                            <textarea v-model='message_area[active_ticket.id].message'
                                      placeholder="Type your message here..."></textarea>
                        </label>
                        <div class="btn">
                            <button type="button"><span class="icon-smile"></span></button>
                            <button type="button"><label><input type="file"><span class="icon-file"></span></label>
                            </button>
                            <button type="button" @click="sendMessage"><span class="icon-send"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fragment>
</template>
<script>
export default {
    mounted() {
        this.getTickets().then(data => {
            this.tickets = data;
            let messageArea = this.message_area;
            $.each(data, function (key, value) {
                messageArea[value.id] = {message: ''};
            });
        });
    },
    data: function () {
        return {
            active_ticket: [],
            tickets: [],
            messages: [],
            message_area: []
        }
    },
    methods: {
        getTickets: function () {
            let d = $.Deferred();

            axios.get('/api-admin/support/tickets')
                .then((response) => {
                    d.resolve(response.data.tickets);
                });

            return d.promise();
        },
        getMessagesOnClick: function (e) {
            this.active_ticket = this.tickets[e.currentTarget.getAttribute('data-key')];
            let ticket_id = e.currentTarget.getAttribute('data-id');
            this.getMessages(ticket_id)
        },
        getMessages: function (ticket_id) {
            axios.get('/api-admin/support/messages/' + ticket_id)
                .then((response) => {
                    this.messages = response.data.messages;
                    this.markAsRead(ticket_id)
                });
        },
        markAsRead: function (ticket_id) {
            axios.post('/api-admin/support/messages-mark-read', {
                ticket_id: ticket_id
            }).then((response) => {
                this.$parent.getCount().then(data => {
                    this.$parent.messages_count = data;
                });
            });
        },
        sendMessage: function () {
            let activeTicketId = this.active_ticket.id;
            axios.post('/api-admin/support/message-send', {
                ticket_id: activeTicketId,
                message: this.message_area[activeTicketId].message
            }).then((response) => {
                this.message_area[activeTicketId].message = '';
                this.getMessages(activeTicketId)
            });
        }
    }
}
</script>
