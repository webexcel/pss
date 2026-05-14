<!DOCTYPE html>
<html>
<head>
    <title>Auto Start Application</title>
    <style>
        body {
            font-family: monospace;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 600px;
            text-align: center;
        }
        .status {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 14px;
            text-align: left;
        }
        .success { color: #059669; font-weight: bold; }
        .error { color: #dc2626; font-weight: bold; }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Starting Application...</h1>
        <div class="spinner"></div>
        <div id="status" class="status">
            <div id="log"></div>
        </div>
    </div>

    <script>
        const log = document.getElementById('log');

        function addLog(message, type = 'info') {
            const className = type === 'success' ? 'success' : (type === 'error' ? 'error' : '');
            log.innerHTML += `<p class="${className}">${message}</p>`;
        }

        async function startApplication() {
            try {
                addLog('1. Calling API to start application...');

                const response = await fetch('/pssxi/api/application/start', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();
                addLog('API Response: ' + JSON.stringify(data).substring(0, 100) + '...');

                if (!data.success) {
                    addLog('❌ API Error: ' + data.message, 'error');
                    return;
                }

                const token = data.data.token;
                const appId = data.data.application_id;

                addLog('✅ Application started!', 'success');
                addLog('Token: ' + token.substring(0, 20) + '...');
                addLog('App ID: ' + appId);

                // Store in sessionStorage
                addLog('2. Storing in browser sessionStorage...');
                sessionStorage.setItem('app_token', token);
                sessionStorage.setItem('application_id', appId);
                addLog('✅ Stored in sessionStorage', 'success');

                // Sync to PHP session
                addLog('3. Syncing to PHP session...');
                const sessionResp = await fetch('/pssxi/session.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        app_token: token,
                        application_id: appId
                    })
                });

                const sessionData = await sessionResp.json();
                addLog('Session Response: ' + JSON.stringify(sessionData));

                if (sessionData.success) {
                    addLog('✅ PHP Session synced!', 'success');
                    addLog('4. Redirecting to step1.php in 2 seconds...');

                    setTimeout(() => {
                        window.location.href = 'step1.php';
                    }, 2000);
                } else {
                    addLog('❌ Session sync failed: ' + sessionData.message, 'error');
                }

            } catch (error) {
                addLog('❌ Error: ' + error.message, 'error');
                console.error(error);
            }
        }

        // Start automatically
        startApplication();
    </script>
</body>
</html>
