# Install once:
# pip install gTTS

from gtts import gTTS

# === Tanglish Text ===
tanglish_text = """
Engal palli app vazhikattikku varaverkirvom.
Padi 1: WhatsApp kuzhuvil pagirappatta innaippai klik seiyavum.
Padi 2: App-ai nizhuvi, engal palliyin peyar matrum logovai paarthu uruthiseiyavum.
Padi 3: App-ai thirandhu ungal padhivu seiyappatta mobile ennai ullidavum.
Padi 4: Sariyana enn koduthaal, serkkai ennai OTP aaga kekkum.
Padi 5: Ulnuzhaindha pin, Dashboard pagaththirku sellalaam.
Angirunthu anaitthu vasadhigalaiyum paarkkalaam.
"""

# === Generate Tanglish Audio ===
tts = gTTS(text=tanglish_text, lang='ta')  # Indian English accent
tts.save("narration_tanglish.mp3")

print("✅ Tanglish audio saved as narration_tanglish.mp3")
