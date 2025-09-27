<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>感謝ゲーム</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<script>
    console.log("increment route: {{ route('thanks.increment') }}");
</script>


<body class="bg-gradient-to-r from-pink-200 via-red-100 to-yellow-100 min-h-screen flex items-center justify-center px-4">

    <!-- 白いカード -->
    <div
        x-data="thankGame({{ Js::from(['total' => $total, 'today' => $today]) }})"
        x-init="init()"
        class="bg-white shadow-xl rounded-2xl p-4 sm:p-8 w-full max-w-md text-center transition-all duration-300">

        <!-- タイトル -->
        <h1 class="text-2xl sm:text-3xl font-bold text-pink-600 mb-6">🙏 感謝ゲーム ❤️</h1>

        <!-- 名前入力 -->
        <div class="mb-4 text-left">
            <label class="block text-sm font-medium text-gray-700 mb-1">あなたの名前（任意・ランキング表示用）</label>
            <input type="text" x-model="userName" placeholder="匿名"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" />
            <p class="text-xs text-gray-500 mt-1">未入力の場合は匿名またはIPで記録されます。</p>
        </div>

        <!-- 感謝ボタン -->
        <div class="relative mb-6">
            <button
                @click="sendThanks"
                class="w-full sm:w-auto bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300">
                ❤️ 感謝
            </button>

            <!-- ハートアニメーション -->
            <template x-for="(heart, index) in hearts" :key="index">
                <span
                    x-text="heart.icon"
                    class="absolute text-red-500 text-3xl animate-bounce"
                    :style="`top:${heart.top}px; left:${heart.left}px;`"></span>
            </template>
        </div>

        <!-- スコア表示 -->
        <div class="mt-6 space-y-2">
            <p class="text-lg sm:text-xl text-gray-800">今日の感謝: <span x-text="today"></span> 回</p>
            <p class="text-base sm:text-lg text-gray-600">総合: <span x-text="total"></span> 回</p>
        </div>

        <!-- ランキング -->
        <div class="mt-8">
            <h2 class="text-xl sm:text-2xl font-semibold text-pink-500 mb-4">ランキング</h2>
            <ul class="space-y-1 text-base sm:text-lg text-gray-700">
                @foreach ($ranking as $r)
                <li>🙇 {{ $r->user ?? '匿名' }}：{{ $r->count }}回</li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        function thankGame(boot) {
            return {
                total: boot.total,
                today: boot.today,
                hearts: [],
                userName: '',
                init() {
                    // 名前をローカル保存して復元
                    const saved = localStorage.getItem('thankUserName');
                    if (saved) this.userName = saved;
                    this.$watch('userName', (v) => localStorage.setItem('thankUserName', v || ''));
                },
                async sendThanks() {
                    this.hearts.push({
                        icon: "❤️",
                        top: -40,
                        left: 40 + Math.random() * 60
                    });
                    setTimeout(() => this.hearts.shift(), 1000);

                    try {
                        const res = await fetch("{{ route('thanks.increment') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({ user: this.userName?.trim() || null })
                        });

                        if (!res.ok) {
                            console.error("リクエスト失敗:", res.status, await res.text());
                            return;
                        }

                        const data = await res.json();
                        this.total = data.total;
                        this.today = data.today;
                    } catch (e) {
                        console.error("通信エラー:", e);
                    }
                }
            };
        }
    </script>
</body>

</html>
