# Website Security Checker with Telegram Alerts

This PHP script scans a list of websites for potential security warnings (such as phishing or malware warnings) by checking HTTP headers and page content. It then sends alerts to a specified Telegram group or chat via a bot.

---

## Features

- Checks HTTP response headers for common restriction status codes (e.g., 403, 451)
- Scans page content for common security warning phrases
- Sends notifications to a Telegram group or chat using a bot
- Supports multiple websites in a single run
- Simple to set up and customize

---

## Requirements

- PHP 7.0 or higher with `curl` enabled
- A Telegram bot token (from [BotFather](https://t.me/BotFather))
- The Telegram bot must be added to your target group/chat with permission to send messages

---

## Setup

1. **Create a Telegram bot** and get the bot token.

2. **Add your bot to the Telegram group/chat** where you want to receive alerts.

3. **Set your bot token as an environment variable** (recommended for security):

   ```bash
   export TELEGRAM_BOT_TOKEN="YOUR_BOT_TOKEN_HERE"
