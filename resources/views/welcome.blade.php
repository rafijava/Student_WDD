<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management API — Documentation & Tester</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            background: #f5f7fa;
            color: #1f2937;
            line-height: 1.5;
        }
        header {
            background: #111827;
            color: #fff;
            padding: 1.5rem 2rem;
        }
        header h1 { margin: 0; font-size: 1.5rem; }
        .container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        h2 { margin-top: 0; color: #111827; }
        label { display: block; font-weight: 600; margin-bottom: 0.25rem; font-size: 0.9rem; }
        input, select, textarea, button {
            font: inherit;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 0.6rem 0.75rem;
            width: 100%;
        }
        textarea { min-height: 160px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; }
        .row { display: flex; gap: 1rem; flex-wrap: wrap; }
        .col { flex: 1; min-width: 220px; }
        .btn {
            background: #2563eb;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: 600;
            width: auto;
            padding: 0.7rem 1.5rem;
        }
        .btn:hover { background: #1d4ed8; }
        .response { background: #1f2937; color: #e5e7eb; padding: 1rem; border-radius: 6px; overflow-x: auto; white-space: pre-wrap; min-height: 120px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { text-align: left; padding: 0.6rem; border-bottom: 1px solid #e5e7eb; font-size: 0.9rem; }
        th { background: #f9fafb; }
        .method { font-weight: bold; }
        .method.get { color: #059669; }
        .method.post { color: #2563eb; }
        .method.put { color: #d97706; }
        .method.delete { color: #dc2626; }
        .badge { font-size: 0.75rem; padding: 0.15rem 0.4rem; border-radius: 999px; background: #e5e7eb; color: #374151; }
        .mt { margin-top: 1rem; }
        .hint { color: #6b7280; font-size: 0.85rem; }
    </style>
</head>
<body>
    <header>
        <h1>Student Management API — Documentation & Interactive Tester</h1>
        <p>Sanctum token auth · Admin + Staff roles · MySQL backend</p>
    </header>

    <div class="container">
        <div class="card">
            <h2>1. Try an Endpoint</h2>
            <div class="row">
                <div class="col" style="flex: 2;">
                    <label for="baseUrl">Base URL</label>
                    <input type="text" id="baseUrl" value="{{ url('/api') }}" placeholder="http://127.0.0.1:8000/api">
                </div>
                <div class="col" style="flex: 3;">
                    <label for="token">Bearer Token (leave empty for public endpoints)</label>
                    <input type="text" id="token" placeholder="1|xxxxxxxxxxxxxxxxx">
                </div>
            </div>

            <div class="row mt">
                <div class="col" style="flex: 1;">
                    <label for="method">Method</label>
                    <select id="method">
                        <option value="GET">GET</option>
                        <option value="POST" selected>POST</option>
                        <option value="PUT">PUT</option>
                        <option value="DELETE">DELETE</option>
                    </select>
                </div>
                <div class="col" style="flex: 3;">
                    <label for="endpoint">Endpoint</label>
                    <select id="endpointSelect" onchange="applyEndpoint()">
                        <option value="" data-method="POST" data-body=''>-- pick a sample --</option>
                        <option value="/register" data-method="POST" data-body='{"name":"Admin","email":"admin@example.com","password":"password","role":"admin"}'>POST /register</option>
                        <option value="/login" data-method="POST" data-body='{"email":"admin@example.com","password":"password"}'>POST /login</option>
                        <option value="/students" data-method="GET" data-body=''>GET /students</option>
                        <option value="/students" data-method="POST" data-body='{"name":"Alice Smith","student_id":"S1001","department":"CSE","marks":85.5,"email":"alice@example.com"}'>POST /students</option>
                        <option value="/students/1" data-method="PUT" data-body='{"department":"EEE"}'>PUT /students/1</option>
                        <option value="/students/1" data-method="DELETE" data-body=''>DELETE /students/1</option>
                        <option value="/courses" data-method="GET" data-body=''>GET /courses</option>
                        <option value="/courses" data-method="POST" data-body='{"course_id":"C101","title":"Algorithms","capacity":1,"fee":5000}'>POST /courses</option>
                        <option value="/courses/1" data-method="PUT" data-body='{"fee":5500}'>PUT /courses/1</option>
                        <option value="/courses/1" data-method="DELETE" data-body=''>DELETE /courses/1</option>
                        <option value="/enrollments" data-method="GET" data-body=''>GET /enrollments</option>
                        <option value="/enrollments" data-method="POST" data-body='{"student_id":1,"course_id":1}'>POST /enrollments</option>
                        <option value="/import-legacy" data-method="POST" data-body='{"students":[{"full_name":"Legacy","roll":"L9001","dept":"CSE","score":"78.5","mail":"legacy@example.com"}]}'>POST /import-legacy</option>
                    </select>
                </div>
            </div>

            <div class="row mt">
                <div class="col" style="flex: 1;">
                    <label for="manualEndpoint">Or type endpoint</label>
                    <input type="text" id="manualEndpoint" value="/login" placeholder="/students/1">
                </div>
            </div>

            <div class="mt">
                <label for="body">JSON Body</label>
                <textarea id="body">{
  "email": "admin@example.com",
  "password": "password"
}</textarea>
                <p class="hint">For GET/DELETE requests the body is ignored.</p>
            </div>

            <div class="mt">
                <button class="btn" onclick="sendRequest()">Send Request</button>
            </div>

            <div class="mt">
                <label>Response</label>
                <div id="status" class="hint">Status: —</div>
                <div id="response" class="response">Click "Send Request" to see the response here.</div>
            </div>
        </div>

        <div class="card">
            <h2>2. Endpoint Reference</h2>
            <table>
                <thead>
                    <tr><th>Method</th><th>Endpoint</th><th>Access</th><th>Notes</th></tr>
                </thead>
                <tbody>
                    <tr><td class="method post">POST</td><td>/register</td><td>public</td><td>Create Admin/Staff user</td></tr>
                    <tr><td class="method post">POST</td><td>/login</td><td>public</td><td>Returns Bearer token</td></tr>
                    <tr><td class="method get">GET</td><td>/students</td><td>admin, staff</td><td>Paginated list</td></tr>
                    <tr><td class="method get">GET</td><td>/students/{id}</td><td>admin, staff</td><td>Single student</td></tr>
                    <tr><td class="method post">POST</td><td>/students</td><td>admin only</td><td>Create student</td></tr>
                    <tr><td class="method put">PUT</td><td>/students/{id}</td><td>admin only</td><td>Update student</td></tr>
                    <tr><td class="method delete">DELETE</td><td>/students/{id}</td><td>admin only</td><td>Delete student</td></tr>
                    <tr><td class="method get">GET</td><td>/courses</td><td>admin, staff</td><td>Paginated list</td></tr>
                    <tr><td class="method get">GET</td><td>/courses/{id}</td><td>admin, staff</td><td>Single course</td></tr>
                    <tr><td class="method post">POST</td><td>/courses</td><td>admin only</td><td>Create course</td></tr>
                    <tr><td class="method put">PUT</td><td>/courses/{id}</td><td>admin only</td><td>Update course</td></tr>
                    <tr><td class="method delete">DELETE</td><td>/courses/{id}</td><td>admin only</td><td>Delete course</td></tr>
                    <tr><td class="method get">GET</td><td>/enrollments</td><td>admin, staff</td><td>Paginated list</td></tr>
                    <tr><td class="method post">POST</td><td>/enrollments</td><td>admin, staff</td><td>Enroll; rejects duplicates & full courses</td></tr>
                    <tr><td class="method post">POST</td><td>/import-legacy</td><td>admin only</td><td>Legacy JSON student import via adapter</td></tr>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h2>3. Quick Start</h2>
            <ol>
                <li>Choose <strong>POST /login</strong> and click <strong>Send Request</strong>.</li>
                <li>Copy the <code>token</code> from the response and paste it into the <strong>Bearer Token</strong> field.</li>
                <li>Now test protected endpoints such as <strong>GET /students</strong> or <strong>POST /students</strong>.</li>
            </ol>
            <p class="hint">Seeded users: <code>admin@example.com / password</code> (admin) and <code>staff@example.com / password</code> (staff).</p>
        </div>
    </div>

    <script>
        function applyEndpoint() {
            const select = document.getElementById('endpointSelect');
            const option = select.options[select.selectedIndex];
            const path = option.value;
            const method = option.getAttribute('data-method');
            const body = option.getAttribute('data-body');

            if (!path) return;

            document.getElementById('manualEndpoint').value = path;
            document.getElementById('method').value = method;
            document.getElementById('body').value = body ? JSON.stringify(JSON.parse(body), null, 2) : '';
        }

        async function sendRequest() {
            const base = document.getElementById('baseUrl').value.trim().replace(/\/$/, '');
            const path = document.getElementById('manualEndpoint').value.trim();
            const method = document.getElementById('method').value;
            const token = document.getElementById('token').value.trim();
            const bodyText = document.getElementById('body').value;

            const url = base + path;
            const headers = {
                'Accept': 'application/json',
            };

            if (token) {
                headers['Authorization'] = 'Bearer ' + token;
            }

            const options = { method, headers };

            if (method !== 'GET' && method !== 'DELETE' && bodyText.trim()) {
                headers['Content-Type'] = 'application/json';
                options.body = bodyText;
            }

            const statusEl = document.getElementById('status');
            const responseEl = document.getElementById('response');

            try {
                const res = await fetch(url, options);
                const text = await res.text();
                let formatted = text;
                try {
                    formatted = JSON.stringify(JSON.parse(text), null, 2);
                } catch (e) {}
                statusEl.textContent = 'Status: ' + res.status + ' ' + res.statusText;
                responseEl.textContent = formatted;
            } catch (err) {
                statusEl.textContent = 'Network / CORS Error';
                responseEl.textContent = err.message;
            }
        }
    </script>
</body>
</html>
