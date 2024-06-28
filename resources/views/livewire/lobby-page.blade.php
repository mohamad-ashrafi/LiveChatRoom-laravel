<div class="w-full h-svh grid grid-cols-12 p-4 bg-gray-100 gap-4 dark:bg-secondary-950">
    <aside class="col-span-4 flex flex-col gap-4">
        <div class="bg-white p-4 ring-1 ring-secondary-200 rounded-md dark:bg-secondary-900 dark:ring-secondary-800">

            <div class="flex items-center gap-4">
                <div
                    class="w-10 h-10 min-w-10 min-h-10 bg-secondary-200 dark:bg-secondary-800 rounded-md overflow-hidden">
                        <img src="{{asset('storage/' .auth()->user()->avatar)}}" class="w-50 h-full object-cover rounded" alt="">
                </div>
                <div class="text-sm flex flex-col gap-1 truncate">
                    <p class="text-secondary-700 dark:text-secondary-300 truncate">
                        {{ auth()->user()->user_name }}
                    </p>
                    <button class="text-secondary-500 text-xs dark:text-secondary-400 truncate">
                        {{ auth()->user()->email }}
                    </button>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mt-4 bg-red-600 text-white px-4 py-2 rounded-md">خروج</button>
                </form>


            </div>
            <div class="mt-8">
                <a href="" id="btn-dark" class="mt-4 bg-gray-800 text-white px-4 py-2 rounded-md">تم تاریک</a>
                <a href="" id="btn-light" class="mt-4 bg-amber-400 text-black px-4 py-2 rounded-md">تم روشن</a>
            </div>

        </div>
        <div
            class="flex-auto h-0 bg-white ring-1 ring-secondary-200 rounded-md flex flex-col dark:bg-secondary-900 dark:ring-secondary-800">
            <div class="px-4 py-4">
                <p class="text-primary-600 dark:text-primary-500">
                    کاربران آنلاین
                </p>
            </div>
            <ul id="online-users-list" class="flex flex-col gap-4 flex-auto h-0 scroll overflow-y-auto px-4 truncate">
            </ul>
        </div>
    </aside>

    <main class="col-span-8 flex flex-col items-center justify-between gap-4">
        <div
            id="chat-list-wrapper"
            class="flex-auto h-0 overflow-y-auto w-full scroll rounded-md ring-1 ring-secondary-200 w-full p-4 bg-white dark:bg-secondary-900 dark:ring-secondary-800">
            <ul class="flex flex-col gap-4" id="chat-list">
                @foreach($this->systemMessages() as $systemMessage)
                    <li class="flex items-start gap-4">
                        <div
                            class="min-w-10 min-h-10 w-10 h-10 bg-secondary-100 dark:bg-secondary-800 rounded-md overflow-hidden">
                            <img src="{{ asset('login.png') }}" alt=""
                                 class="w-full h-full object-center object-cover">
                        </div>
                        <div class="text-sm flex flex-col gap-1">
                            <div class="text-secondary-500 flex gap-4 dark:text-secondary-400">
                                <div class="flex gap-1 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                    <p>
                                         مدیر گروه
                                    </p>
                                </div>
                            </div>
                            <p class="text-secondary-700 message dark:text-secondary-300">
                                {{ $systemMessage }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>

        </div>

        <div
            class="rounded-md ring-1 ring-secondary-200 w-full p-4 bg-white dark:bg-secondary-900 dark:ring-secondary-800">
            <form id="form-message" class="flex w-full gap-4">
                <label for="input-message" class="grow">
                    <input
                        required
                        name="message"
                        type="text"
                        id="input-message"
                        class="w-full px-4 py-2 rounded-md outline-none bg-secondary-100
                        ring-1 ring-secondary-200 dark:bg-secondary-800 dark:ring-secondary-700
                        dark:placeholder:text-secondary-500 dark:text-secondary-300"
                        placeholder="پیام خود را بنویسید..."
                    >
                </label>
                <button id="btn-message" class="bg-primary-600 dark:bg-primary-800 px-4 py-2 rounded-md text-white">
                    ارسال پیام
                </button>
            </form>
        </div>
    </main>
</div>

@script
<script>
    const chatListWrapper = document.getElementById('chat-list-wrapper');
    const chatList = document.getElementById('chat-list');
    const usersList = document.getElementById('online-users-list');
    const inputMessage = document.getElementById('input-message');
    const messageForm = document.getElementById('form-message');
    const messageButton = document.getElementById('btn-message');
    const darkTheme = document.getElementById('btn-dark');
    const lightTheme = document.getElementById('btn-light');

    inputMessage.addEventListener('keyup', handleMessageInputTypingEvent);
    messageButton.addEventListener('click', broadcastMessage);
    messageForm.addEventListener('submit', broadcastMessage);
    darkTheme.addEventListener('click', darkThemeAction);
    lightTheme.addEventListener('click', lightThemeAction);

    updateScrollPosition();

    Echo.join('lobby')
        .here(handleHereUsers)
        .joining(handleUserJoining)
        .leaving(handleUserLeaving)
        .listenForWhisper('typing', handleTypingWhisper)
        .listenForWhisper('new-message', handleNewMessageWhisper)
    ;

    function darkThemeAction(event){
        event.preventDefault();
        document.querySelector('html').classList.add('dark');
    }

    function lightThemeAction(event){
        event.preventDefault();
        document.querySelector('html').classList.remove('dark');
    }


    function broadcastMessage(event)
    {
        event.preventDefault();

        let message = inputMessage.value.trim();

        if (message.length <= 0)
        {
            return;
        }

        const data = {
            message: message,
            user   : {
                avatar      : '{{ asset('storage/' .auth()->user()->avatar) }}',
                user_name: '{{ auth()->user()->user_name }}',
                uuid        : '{{ auth()->user()->email }}',
            },
        };

        // send message
        Echo.join('lobby')
            .whisper(
                'new-message',
                data
            );

        chatList.innerHTML += renderMessage(data.user.avatar, 'شما', data.message);
        inputMessage.value = '';
        updateScrollPosition();
    }

    function handleNewMessageWhisper(event)
    {
        chatList.innerHTML += renderMessage(event.user.avatar, event.user.user_name, event.message);
        updateScrollPosition();
    }

    const typingTimeOutIds = {};

    function handleTypingWhisper(event)
    {
        if (typingTimeOutIds[event.uuid])
        {
            clearTimeout(typingTimeOutIds[event.uuid]);
        }

        typingTimeOutIds[event.uuid] = setTimeout(
            () =>
            {
                document.getElementById(`online-user-status-${event.uuid}`).innerText = 'آنلاین';
            },
            2000
        );

        document.getElementById(`online-user-status-${event.uuid}`).innerText = 'درحال نوشتن...';
    }

    function handleMessageInputTypingEvent(event)
    {
        Echo.join('lobby')
            .whisper(
                'typing',
                {
                    user_name: '{{ auth()->user()->user_name }}',
                    uuid        : '{{ auth()->user()->email }}',
                    message     : inputMessage.value,
                }
            );
    }

    function handleHereUsers(users)
    {
        users.forEach(user => addUserToOnlineList(user));
    }

    function handleUserJoining(user)
    {
        chatList.innerHTML += renderMessage(user.avatar , user.user_name, 'وارد گروه شد!');
        updateScrollPosition();

        addUserToOnlineList(user);
    }

    function addUserToOnlineList(user)
    {
        const onlineUserElement = document.getElementById(`online-user-wrapper-${user.uuid}`);

        if (!onlineUserElement)
            usersList.innerHTML += renderOnlineUsers(user.avatar, user.user_name, user.uuid);
    }

    function handleUserLeaving(user)
    {
        chatList.innerHTML += renderMessage(user.avatar, user.user_name, 'از گروه خارج شد!');
        updateScrollPosition();
        const onlineUserElement = document.getElementById(`online-user-wrapper-${user.uuid}`);

        if (onlineUserElement)
        {
            onlineUserElement.remove();
        }
    }

    function renderMessage(avatar, user_name, message)
    {
        return `
        <li class="flex items-start gap-4">
            <div class="min-w-10 min-h-10 w-10 h-10 bg-secondary-100 dark:bg-secondary-800 rounded-md overflow-hidden">
                <img src="${avatar}" alt="" class="w-full h-full object-center object-cover">
            </div>
            <div class="text-sm flex flex-col gap-1">
                <div class="text-secondary-500 dark:text-secondary-400 flex gap-4">
                    <div class="flex gap-1 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <p>
                            ${user_name}
                        </p>
                    </div>
                </div>
                <p class="text-secondary-700 dark:text-secondary-300 message">
                    ${message}
                </p>
            </div>
        </li>`;
    }

    function renderOnlineUsers(avatar, user_name, uuid)
    {
        return `
            <li id="online-user-wrapper-${uuid}" class="flex items-center gap-4 truncate">
                <div class="w-10 h-10 min-w-10 min-h-10 bg-secondary-200 dark:bg-secondary-800 rounded-md overflow-hidden">
                     <img src="{{asset('storage/')}}/${avatar}" alt="" class="w-full h-full object-center object-cover">
                </div>
                <div class="text-sm truncate">
                    <p class="text-secondary-700 dark:text-secondary-300 truncate">
                        ${user_name}
                    </p>
                    <p id="online-user-status-${uuid}" class="text-secondary-500 dark:text-secondary-400 text-xs truncate">
                        آنلاین
                    </p>
                </div>
            </li>
        `;
    }


    function updateScrollPosition()
    {
        chatListWrapper.scrollTop = chatListWrapper.scrollHeight;
    }
</script>
@endscript
