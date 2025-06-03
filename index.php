<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Condition ICD-10CM Lookup</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .search-section {
            padding: 40px;
            background: white;
        }

        .search-container {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .search-input {
            flex: 1;
            min-width: 300px;
            padding: 15px 20px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .search-input:focus {
            outline: none;
            border-color: #4facfe;
            background: white;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        }

        .search-btn {
            padding: 15px 30px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 172, 254, 0.3);
        }

        .search-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #64748b;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #e1e8ed;
            border-top: 4px solid #4facfe;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .results-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .condition-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #e1e8ed;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .condition-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .condition-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .condition-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .condition-name::before {
            content: '🏥';
            font-size: 1.2rem;
        }

        .icd-codes {
            margin-top: 15px;
        }

        .icd-code-item {
            background: #f1f5f9;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 12px;
            border-left: 4px solid #4facfe;
            transition: all 0.3s ease;
        }

        .icd-code-item:hover {
            background: #e2e8f0;
            transform: translateX(5px);
        }

        .icd-code {
            font-size: 1.1rem;
            font-weight: 600;
            color: #4facfe;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .icd-code::before {
            content: '📋';
            font-size: 0.9rem;
        }

        .icd-description {
            color: #475569;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .no-results-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 15px 20px;
            border-radius: 12px;
            margin: 20px 0;
            border-left: 4px solid #dc2626;
        }

        .help-text {
            background: #eff6ff;
            color: #1e40af;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border-left: 4px solid #3b82f6;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .search-container {
                flex-direction: column;
            }
            
            .search-input {
                min-width: auto;
            }
            
            .results-container {
                grid-template-columns: 1fr;
            }
            
            .condition-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Medical Condition ICD-10CM Lookup</h1>
            <p>
				Search for medical conditions and get their ICD-10CM codes <br>
				by p.velante@gmail.com
			</p>
        </div>
        
        <div class="search-section">
            <div class="help-text">
                💡 Enter medical conditions separated by commas (e.g., "gastroenteritis, diabetes, hypertension")
            </div>
            
            <div class="search-container">
                <input 
                    type="text" 
                    id="conditionInput" 
                    class="search-input" 
                    placeholder="Enter medical conditions separated by commas..."
                    onkeypress="handleKeyPress(event)"
                >
                <button id="searchBtn" class="search-btn" onclick="searchConditions()">
                    Search Conditions
                </button>
            </div>
            
            <div id="loadingDiv" class="loading" style="display: none;">
                <div class="spinner"></div>
                <p>Searching medical conditions...</p>
            </div>
            
            <div id="errorDiv" class="error-message" style="display: none;"></div>
            
            <div id="resultsContainer" class="results-container"></div>
        </div>
    </div>

    <script>
        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                searchConditions();
            }
        }

        async function searchConditions() {
            const input = document.getElementById('conditionInput');
            const loadingDiv = document.getElementById('loadingDiv');
            const errorDiv = document.getElementById('errorDiv');
            const resultsContainer = document.getElementById('resultsContainer');
            const searchBtn = document.getElementById('searchBtn');
            
            const conditions = input.value.trim();
            
            if (!conditions) {
                showError('Please enter at least one medical condition.');
                return;
            }
            
            // Clear previous results and errors
            errorDiv.style.display = 'none';
            resultsContainer.innerHTML = '';
            loadingDiv.style.display = 'block';
            searchBtn.disabled = true;
            searchBtn.textContent = 'Searching...';
            
            try {
                // Split conditions by comma and trim whitespace
                const conditionList = conditions.split(',').map(c => c.trim()).filter(c => c);
                const results = [];
                
                // Search each condition
                for (const condition of conditionList) {
                    try {
                        const result = await searchSingleCondition(condition);
                        if (result) {
                            results.push(result);
                        }
                    } catch (error) {
                        console.error(`Error searching for ${condition}:`, error);
                        results.push({
                            searchTerm: condition,
                            error: `Failed to search for "${condition}"`
                        });
                    }
                }
                
                displayResults(results);
                
            } catch (error) {
                console.error('Search error:', error);
                showError('An error occurred while searching. Please try again.');
            } finally {
                loadingDiv.style.display = 'none';
                searchBtn.disabled = false;
                searchBtn.textContent = 'Search Conditions';
            }
        }

        async function searchSingleCondition(condition) {
            const encodedCondition = encodeURIComponent(condition);
            const url = `https://clinicaltables.nlm.nih.gov/api/conditions/v3/search?terms=${encodedCondition}&sf=consumer_name&ef=icd10cm_codes,icd10cm`;
            
            try {
                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                // Parse the response format: [count, [ids], {data}, [[names]]]
                if (data && data.length >= 4 && data[0] > 0) {
                    const count = data[0];
                    const ids = data[1];
                    const details = data[2];
                    const names = data[3];
                    
                    return {
                        searchTerm: condition,
                        count: count,
                        conditions: names.map((nameArray, index) => ({
                            name: nameArray[0],
                            id: ids[index],
                            icd10Codes: details.icd10cm[index] || [],
                            icd10CodesList: details.icd10cm_codes[index] || []
                        }))
                    };
                } else {
                    return {
                        searchTerm: condition,
                        count: 0,
                        conditions: []
                    };
                }
            } catch (error) {
                console.error(`Error fetching data for ${condition}:`, error);
                throw error;
            }
        }

        function displayResults(results) {
            const resultsContainer = document.getElementById('resultsContainer');
            
            if (results.length === 0) {
                resultsContainer.innerHTML = `
                    <div class="no-results">
                        <div class="no-results-icon">🔍</div>
                        <h3>No results found</h3>
                        <p>Please try different medical condition terms.</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            
            results.forEach(result => {
                if (result.error) {
                    html += `
                        <div class="condition-card">
                            <div class="condition-name">${result.searchTerm}</div>
                            <div class="error-message" style="display: block;">
                                ${result.error}
                            </div>
                        </div>
                    `;
                } else if (result.count === 0) {
                    html += `
                        <div class="condition-card">
                            <div class="condition-name">${result.searchTerm}</div>
                            <div class="no-results">
                                <p>No matching conditions found.</p>
                            </div>
                        </div>
                    `;
                } else {
                    result.conditions.forEach(condition => {
                        html += `
                            <div class="condition-card">
                                <div class="condition-name">${condition.name}</div>
                                <div class="icd-codes">
                        `;
                        
                        if (condition.icd10Codes && condition.icd10Codes.length > 0) {
                            condition.icd10Codes.forEach(icdItem => {
                                html += `
                                    <div class="icd-code-item">
                                        <div class="icd-code">ICD-10 Code: ${icdItem.code}</div>
                                        <div class="icd-description">${icdItem.name}</div>
                                    </div>
                                `;
                            });
                        } else {
                            html += `
                                <div class="icd-code-item">
                                    <div class="icd-description">No ICD-10 codes available for this condition.</div>
                                </div>
                            `;
                        }
                        
                        html += `</div></div>`;
                    });
                }
            });
            
            resultsContainer.innerHTML = html;
        }

        function showError(message) {
            const errorDiv = document.getElementById('errorDiv');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        }

        // Focus on input when page loads
        window.addEventListener('load', () => {
            document.getElementById('conditionInput').focus();
        });
    </script>
</body>
</html>