# Install first (only once)
# pip install gTTS

from gtts import gTTS

# === Your text ===
text = """
Welcome to the School App guide.
Step 1: Click the link shared in the WhatsApp group.
Step 2: Install the app and recognize it by our school name and logo.
Step 3: Open the app and enter your registered mobile number.
Step 4: If correct, enter your Admission Number as OTP.
Step 5: After login, you will reach the Dashboard page.
Thank you.
"""

# === Generate audio ===
tts = gTTS(text=text, lang='en', tld='co.in')  # 'co.in' gives Indian accent (female voice)
tts.save("narration.mp3")

print("✅ Audio saved as narration.mp3")
