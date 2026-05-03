College AI Chatbot (PHP only)
============================

Contents:
- config.php       -> Put your OpenAI API key here
- chatbot.php      -> Combined UI + backend (no separate JS files)

How to use:
1. Copy both files to your web server folder (e.g., /var/www/html/college/).
2. Open config.php and replace YOUR_OPENAI_API_KEY with your real key from https://platform.openai.com/
3. Ensure PHP cURL is enabled on your server (php-curl).
   - On Ubuntu/Debian: sudo apt install php-curl && sudo service apache2 restart
4. Open browser: http://localhost/college/chatbot.php (change path as needed)
5. Type a question and press Send.

Notes & Security:
- Keep your API key secret. Do NOT commit config.php to a public repository.
- This simple example sends each user message as a single request to OpenAI.
- For production: add rate-limiting, authentication, input validation, and server-side usage logging.

If you want, I can customize the bot's system prompt, add a small FAQ memory, or implement paid access flow using Razorpay.
