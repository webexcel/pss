# Install dependencies first (only once):
# pip install gTTS moviepy

from gtts import gTTS
from moviepy.editor import VideoFileClip, TextClip, CompositeVideoClip, concatenate_videoclips, AudioFileClip
import os

# === 1. Define narration text (shortened spoken version) ===
script_text = """
Welcome to the School App guide.
Step 1: Click the link shared in the WhatsApp group. It will take you to the Google Play Store.
Step 2: Install the app. You will recognize it by our school name and logo.
Step 3: Open the app and enter your registered mobile number. If you type the wrong number, the app will say 'This number is not registered.'
Step 4: If correct, the app will ask for your Admission Number as OTP. Enter it to continue.
Step 5: After login, you will reach the Dashboard page. From there, you can explore all the modules.
Thank you.
"""

# === 2. Generate narration audio (female Indian accent) ===
tts = gTTS(text=script_text, lang='en', tld='co.in')  # 'co.in' gives Indian accent
audio_file = "narration.mp3"
tts.save(audio_file)

# === 3. Load your original MP4 screen recording ===
video_file = "Recording.mp4"  # <-- use your uploaded file name
video_clip = VideoFileClip(video_file)

# === 4. Create a title card (3 seconds) ===
title = TextClip("School App Installation & Login Guide", fontsize=60, color='white', bg_color='black', size=video_clip.size)
title = title.set_duration(3)

# === 5. Add step labels in sync (simple static labels at top) ===
# You can fine-tune start/end times by listening to narration length
steps = [
    ("Step 1: Install the App", 3, 10),
    ("Step 2: Login", 10, 20),
    ("Step 3: Dashboard", 20, 30),
]

overlays = []
for text, start, end in steps:
    txt = TextClip(text, fontsize=40, color='yellow', bg_color='black', size=(video_clip.w, 60))
    txt = txt.set_position(("center","top")).set_start(start).set_end(end)
    overlays.append(txt)

# === 6. Combine everything ===
# Attach narration audio
narration_audio = AudioFileClip(audio_file)

# Create main clip (after title)
main_with_labels = CompositeVideoClip([video_clip] + overlays)

# Concatenate title + main video
final_video = concatenate_videoclips([title, main_with_labels])

# Replace audio
final_video = final_video.set_audio(narration_audio)

# === 7. Export final video ===
final_video.write_videofile("final_school_app_guide.mp4", codec="libx264", audio_codec="aac")
