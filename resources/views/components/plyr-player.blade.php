<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Plyr with YouTube</title>
    <!-- 1. โหลด Plyr CSS ผ่าน CDN -->
    <link rel="stylesheet" href="https://plyr.io" />
    <style>
        .video-wrapper {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            box-sizing: border-box;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    <!-- โครงสร้างตัว Bootstrap Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="background-color: #0f172a; border: none;">
                <div class="modal-body p-0">
                    <div class="video-wrapper">
                        <!-- โครงสร้างแท็ก Div เปล่าสำหรับ Plyr ใช้ Inject ค่า YouTube API เข้ามา -->
                        <div id="player" class="plyr__video-embed"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. โหลด Plyr JavaScript (ตรวจสัญกรณ์ .js ตัวท้ายเรียบร้อย) -->
    <script src="https://plyr.io"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let player; // ประกาศตัวแปรเก็บอินสแตนซ์ของเครื่องเล่นวิดีโอ
            const videoModal = document.getElementById('videoModal');

            if (videoModal) {
                // ดักจับจังหวะที่ผู้ใช้คลิกเปิด Modal
                videoModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget; // ปุ่มที่ถูกกดเปิด
                    const videoUrl = button.getAttribute('data-video-url'); // รับค่า URL
                    const videoId = getYouTubeId(videoUrl); // คัดแยกเอาเฉพาะ ID

                    if (videoId) {
                        // หากยังไม่เคยเปิดตัวเครื่องเล่น ให้สั่งเริ่มต้นสร้างตัวแปร Plyr ขึ้นมาเป็นครั้งแรก
                        if (!player) {
                            player = new Plyr('#player', {
                                controls: ['play-large', 'play', 'progress', 'current-time', 'mute',
                                    'volume', 'fullscreen'
                                ]
                            });
                        }

                        // สั่งเปลี่ยนวิดีโอแบบไดนามิกผ่านฟังก์ชันทางกฎของ Plyr API โดยตรง
                        player.source = {
                            type: 'video',
                            sources: [{
                                src: videoId,
                                provider: 'youtube', // ระบุเป็นระบบหลังบ้านของ youtube
                            }, ],
                        };

                        // สั่งให้เล่นวิดีโออัตโนมัติทันทีที่เปลี่ยนซอร์สเสร็จเรียบร้อย
                        player.on('ready', () => {
                            player.play();
                        });
                    } else {
                        console.error('ไม่สามารถอ่านรหัสวิดีโอ YouTube จากลิงก์นี้ได้: ', videoUrl);
                    }
                });

                // เมื่อผู้ใช้กดปิด Modal ให้สั่งหยุดการทำงานของวิดีโอทันทีเพื่อป้องกันเสียงดังค้าง
                videoModal.addEventListener('hide.bs.modal', function() {
                    if (player) {
                        player.stop();
                    }
                });
            }

            // ฟังก์ชันแบบละเอียดสำหรับแกะจับ YouTube Video ID รองรับทุกลิงก์ (รวมถึงลิงก์แบบ Shorts)
            function getYouTubeId(url) {
                if (!url) return null;
                const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|shorts\/)([^#\&\?]*).*/;
                const match = url.match(regExp);
                return (match && match[2].length === 11) ? match[2] : null;
            }
        });
    </script>
</body>

</html>
