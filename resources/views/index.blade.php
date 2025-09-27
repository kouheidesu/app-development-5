<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <title>感謝ゲーム</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- alpine.jsを使用するため -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-r from-pink-200 via-red-100 to-yellow-100 min-h-screen flex items-center justify-center">
    <!-- totalとtoday変数に入れる -->
    <div
        x-data="thankGame({{ Js::from(['total' => $total, 'today' => $today]) }})"
        class="bg-white p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-lg text-center">

        <!-- タイトル -->
        <h1 class="text-3xl sm:text-4xl font-bold text-pink-600 mb-6">
            🙏 感謝ゲーム ❤️
        </h1>

        <!-- 感謝ボタン -->
        <div class="relative">
            <button
                @click="sendThanks"
                class="px-12 py-6 sm:px-8 sm:py-4 bg-pink-500 text-white text-xl sm:text-lg font-semibold rounded-full shadow-lg hover:bg-pink-600 transition relative overflow-hidden">
                ❤️ 感謝
            </button>

            <!-- ハートアニメーション -->
            <template x-for="(heart, index) in hearts" :key="index">
                <span
                    x-text="heart.icon"
                    class="absolute text-red-500 text-4xl sm:text-3xl animate-bounce"
                    :style="`top:${heart.top}px; left:${heart.left}px;`"></span>
            </template>
        </div>

        <!-- スコア表示 -->
        <div class="mt-8 space-y-2">
            <p class="text-2xl sm:text-xl text-gray-800">
                今日の感謝: <span x-text="today"></span> 回
            </p>
            <p class="text-xl sm:text-lg text-gray-600">
                総合: <span x-text="total"></span> 回
            </p>
        </div>

        <!-- ランキング -->
        <div class="mt-8">
            <h2 class="text-2xl sm:text-xl font-semibold text-pink-500 mb-4">ランキング</h2>
            <ul class="space-y-1 text-lg sm:text-base text-gray-700">
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

                async sendThanks() {
                    // ハート生成
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
                            }
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