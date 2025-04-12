// Enhanced UI Functionality for Research Proposal System

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all tabs
    initTabs();
    
    // Initialize modals
    initModals();
    
    // Initialize form validation
    initFormValidation();
    
    // Initialize budgets charts if elements exist
    if (document.getElementById('budgetPieChart')) {
      initBudgetCharts();
    }
    
    // Initialize project timeline if element exists
    if (document.getElementById('projectTimeline')) {
      initProjectTimeline();
    }
    
    // Mobile menu toggle
    if (document.querySelector('.mobile-menu-toggle')) {
      document.querySelector('.mobile-menu-toggle').addEventListener('click', function() {
        document.querySelector('.tab').classList.toggle('mobile-visible');
      });
    }
  });
  
  // Tab Navigation Functionality
  function initTabs() {
    const tabs = document.querySelectorAll('.tab button');
    
    tabs.forEach(tab => {
      tab.addEventListener('click', function(e) {
        const targetId = this.getAttribute('data-target') || this.getAttribute('onclick');
        
        // If using onclick attribute with openCity function
        if (targetId && targetId.includes('openCity')) {
          // Extract cityName from the onclick attribute
          const match = targetId.match(/openCity\(event,\s*['"](.+?)['"]\)/);
          if (match && match[1]) {
            openTab(e, match[1]);
          }
        } 
        // If using data-target attribute
        else if (targetId) {
          openTab(e, targetId);
        }
      });
    });
    
    // Find and click the default tab
    const defaultOpen = document.getElementById('defaultOpen');
    if (defaultOpen) {
      defaultOpen.click();
    }
  }
  
  // Open specific tab content
  function openTab(evt, tabName) {
    // Hide all tab content
    const tabcontent = document.getElementsByClassName('tabcontent');
    for (let i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = 'none';
    }
    
    // Remove active class from all tabs
    const tablinks = document.getElementsByClassName('tablinks');
    for (let i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(' active', '');
    }
    
    // Show the specific tab content and add active class to the button
    document.getElementById(tabName).style.display = 'block';
    evt.currentTarget.className += ' active';
    
    // Scroll to top of the tab content for better UX
    window.scrollTo({
      top: document.getElementById(tabName).offsetTop - 100,
      behavior: 'smooth'
    });
  }
  
  // Modal Functionality
  function initModals() {
    // Get all modal triggers
    const modalTriggers = document.querySelectorAll('[data-toggle="modal"]');
    const modalCloseButtons = document.querySelectorAll('.modal .close');
    
    // Add click event to all modal triggers
    modalTriggers.forEach(trigger => {
      trigger.addEventListener('click', function() {
        const targetModal = document.getElementById(this.getAttribute('data-target'));
        if (targetModal) {
          targetModal.style.display = 'block';
        }
      });
    });
    
    // Add click event to close buttons
    modalCloseButtons.forEach(button => {
      button.addEventListener('click', function() {
        this.closest('.modal').style.display = 'none';
      });
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
      if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
      }
    });
    
    // Also handle the legacy modal system
    const myBtn = document.getElementById('myBtn');
    const myModal = document.getElementById('myModal');
    const closeBtn = myModal ? myModal.querySelector('.close') : null;
    
    if (myBtn && myModal) {
      myBtn.onclick = function() {
        myModal.style.display = 'block';
      }
      
      if (closeBtn) {
        closeBtn.onclick = function() {
          myModal.style.display = 'none';
        }
      }
    }
  }
  
  // Form Validation
  function initFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
      form.addEventListener('submit', function(event) {
        const requiredFields = form.querySelectorAll('.required, .requiredm, .requireds, .requiredV');
        let isValid = true;
        
        requiredFields.forEach(field => {
          // Clear previous error styling
          field.style.borderColor = '';
          
          if (!field.value.trim()) {
            field.style.borderColor = 'red';
            isValid = false;
            
            // Create error message if doesn't exist
            let errorMsg = field.nextElementSibling;
            if (!errorMsg || !errorMsg.classList.contains('error-message')) {
              errorMsg = document.createElement('div');
              errorMsg.classList.add('error-message');
              errorMsg.style.color = 'red';
              errorMsg.style.fontSize = '0.8rem';
              errorMsg.style.marginTop = '-10px';
              errorMsg.style.marginBottom = '10px';
              field.parentNode.insertBefore(errorMsg, field.nextSibling);
            }
            
            errorMsg.textContent = 'This field is required';
          } else {
            // Remove error message if field is valid
            const errorMsg = field.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains('error-message')) {
              errorMsg.remove();
            }
          }
        });
        
        if (!isValid) {
          event.preventDefault();
          // Scroll to the first invalid field
          const firstInvalidField = form.querySelector('.required[style*="border-color: red"], .requiredm[style*="border-color: red"], .requireds[style*="border-color: red"], .requiredV[style*="border-color: red"]');
          if (firstInvalidField) {
            firstInvalidField.focus();
            window.scrollTo({
              top: firstInvalidField.offsetTop - 100,
              behavior: 'smooth'
            });
          }
        }
      });
    });
  }
  
  // Dynamic add/remove table rows
  function insRow() {
    const table = document.getElementById('POITable');
    if (!table) return;
    
    const rowCount = table.rows.length;
    const row = table.insertRow(rowCount);
    
    // Clone the first row with input fields
    const cellsFromTemplate = table.rows[1].cells;
    
    // First cell (numbering)
    const cell1 = row.insertCell(0);
    cell1.innerHTML = rowCount;
    if (cellsFromTemplate[0].style.display === 'none') {
      cell1.style.display = 'none';
    }
    
    // Loop through remaining cells
    for (let i = 1; i < cellsFromTemplate.length - 2; i++) {
      const cell = row.insertCell(i);
      
      // Clone the input from template
      const inputTemplate = cellsFromTemplate[i].querySelector('input, select, textarea');
      if (inputTemplate) {
        const newInput = inputTemplate.cloneNode(true);
        newInput.value = '';
        newInput.id = inputTemplate.id + rowCount;
        cell.appendChild(newInput);
      } else {
        cell.innerHTML = cellsFromTemplate[i].innerHTML;
      }
    }
    
    // Add delete button cell
    const deleteCell = row.insertCell(cellsFromTemplate.length - 2);
    deleteCell.innerHTML = '<button type="button" class="btn-delete" onclick="deleteRow(this)">Delete</button>';
    
    // Add empty cell (for add button in template)
    row.insertCell(cellsFromTemplate.length - 1);
  }
  
  function deleteRow(btn) {
    const row = btn.closest('tr');
    if (row.parentNode.rows.length > 2) { // Keep at least one row for template
      row.parentNode.removeChild(row);
      
      // Renumber rows
      const table = row.parentNode;
      for (let i = 1; i < table.rows.length; i++) {
        table.rows[i].cells[0].innerHTML = i;
      }
    }
  }
  
  // Budget Charts
  function initBudgetCharts() {
    // Get budget data from fields or from server
    const budgetData = collectBudgetData();
    
    // Create pie chart for budget distribution
    createBudgetPieChart(budgetData);
    
    // Create bar chart for budget vs. actual expenses
    createBudgetBarChart(budgetData);
  }
  
  function collectBudgetData() {
    // This is a placeholder function to collect budget data
    // In a real application, you would get this data from form fields or from the server
    
    // Try to collect data from inputs if they exist
    const budgetItems = [];
    
    // Get all budget item inputs (assuming they're in a table)
    const personnelInput = document.getElementById('Personnel');
    const researchCostsInput = document.getElementById('ResearchCosts');
    const equipmentInput = document.getElementById('Equipment');
    const travelInput = document.getElementById('Travel');
    const kickoffInput = document.getElementById('kickoff');
    const knowledgeSharingInput = document.getElementById('KnowledgeSharing');
    const overheadCostsInput = document.getElementById('OverheadCosts');
    const otherGoodsInput = document.getElementById('OtherGoods');
    
    // Add items if they exist
    if (personnelInput) budgetItems.push({ name: 'Personnel', value: parseFloat(personnelInput.value) || 0 });
    if (researchCostsInput) budgetItems.push({ name: 'Research Costs', value: parseFloat(researchCostsInput.value) || 0 });
    if (equipmentInput) budgetItems.push({ name: 'Equipment', value: parseFloat(equipmentInput.value) || 0 });
    if (travelInput) budgetItems.push({ name: 'Travel', value: parseFloat(travelInput.value) || 0 });
    if (kickoffInput) budgetItems.push({ name: 'Kickoff Meeting', value: parseFloat(kickoffInput.value) || 0 });
    if (knowledgeSharingInput) budgetItems.push({ name: 'Knowledge Sharing', value: parseFloat(knowledgeSharingInput.value) || 0 });
    if (overheadCostsInput) budgetItems.push({ name: 'Overhead Costs', value: parseFloat(overheadCostsInput.value) || 0 });
    if (otherGoodsInput) budgetItems.push({ name: 'Other Goods', value: parseFloat(otherGoodsInput.value) || 0 });
    
    // Filter out zero values and return
    return budgetItems.filter(item => item.value > 0);
  }
  
  function createBudgetPieChart(budgetData) {
    // If no actual budget data, use sample data
    if (budgetData.length === 0) {
      budgetData = [
        { name: 'Personnel', value: 8000 },
        { name: 'Research Costs', value: 60000 },
        { name: 'Equipment', value: 15000 },
        { name: 'Travel', value: 5000 },
        { name: 'Knowledge Sharing', value: 5000 },
        { name: 'Overhead Costs', value: 7000 }
      ];
    }
    
    const ctx = document.getElementById('budgetPieChart').getContext('2d');
    
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: budgetData.map(item => item.name),
        datasets: [{
          data: budgetData.map(item => item.value),
          backgroundColor: [
            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#5a5c69',
            '#6610f2', '#fd7e14', '#20c997', '#6f42c1', '#e83e8c'
          ],
          hoverBackgroundColor: [
            '#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#be2617', '#3a3b45',
            '#4406b3', '#e56203', '#13795b', '#5d37a0', '#c71666'
          ],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right',
            labels: {
              usePointStyle: true,
              padding: 20
            }
          },
          tooltip: {
            backgroundColor: "rgb(255,255,255)",
            bodyColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            displayColors: false,
            titleMarginBottom: 10,
            titleColor: '#6e707e',
            titleFontSize: 14,
            caretPadding: 10,
            callbacks: {
              label: function(context) {
                return context.label + ': ' + context.parsed.toLocaleString() + ' USD';
              }
            }
          }
        },
        cutout: '50%'
      }
    });
  }
  
  function createBudgetBarChart(budgetData) {
    // This function creates a bar chart comparing planned vs. actual expenses
    // For demo purposes, we'll create random "actual" values based on the planned values
    
    const ctx = document.getElementById('budgetBarChart').getContext('2d');
    
    // If we have real budget data, use it; otherwise use sample data
    let labels = [];
    let plannedValues = [];
    
    if (budgetData.length > 0) {
      labels = budgetData.map(item => item.name);
      plannedValues = budgetData.map(item => item.value);
    } else {
      labels = ['Personnel', 'Research', 'Equipment', 'Travel', 'Other'];
      plannedValues = [8000, 60000, 15000, 5000, 12000];
    }
    
    // Generate random "actual" values for demonstration
    const actualValues = plannedValues.map(val => Math.round(val * (0.8 + Math.random() * 0.4))); // 80-120% of planned
    
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Planned Budget',
            backgroundColor: 'rgba(78, 115, 223, 0.8)',
            borderColor: 'rgba(78, 115, 223, 1)',
            borderWidth: 1,
            data: plannedValues
          },
          {
            label: 'Actual Expenses',
            backgroundColor: 'rgba(28, 200, 138, 0.8)',
            borderColor: 'rgba(28, 200, 138, 1)',
            borderWidth: 1,
            data: actualValues
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        responsive: true,
        scales: {
          x: {
            ticks: {
              maxRotation: 45,
              minRotation: 45
            }
          },
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return value.toLocaleString() + ' USD';
              }
            }
          }
        },
        plugins: {
          legend: {
            display: true
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': ' + context.parsed.y.toLocaleString() + ' USD';
              }
            }
          }
        }
      }
    });
  }
  
  // Project Timeline
  function initProjectTimeline() {
    const ctx = document.getElementById('projectTimeline').getContext('2d');
    
    // Sample data - in a real app, this would come from the database
    const today = new Date();
    const startDate = new Date(today.getFullYear(), today.getMonth(), 1);
    const endDate = new Date(today.getFullYear(), today.getMonth() + 12, 0);
    
    // Create sample milestones
    const milestones = [
      {
        name: 'Project Start',
        date: startDate,
        completed: true
      },
      {
        name: 'First Draft',
        date: new Date(today.getFullYear(), today.getMonth() + 2, 15),
        completed: today > new Date(today.getFullYear(), today.getMonth() + 2, 15)
      },
      {
        name: 'Mid-term Review',
        date: new Date(today.getFullYear(), today.getMonth() + 6, 1),
        completed: false
      },
      {
        name: 'Final Report',
        date: new Date(today.getFullYear(), today.getMonth() + 11, 15),
        completed: false
      },
      {
        name: 'Project End',
        date: endDate,
        completed: false
      }
    ];
    
    // Prepare data for chart
    const labels = milestones.map(m => m.name);
    const data = milestones.map(m => {
      return {
        x: m.date,
        y: labels.indexOf(m.name)
      };
    });
    
    // Create the chart
    new Chart(ctx, {
      type: 'scatter',
      data: {
        datasets: [{
          label: 'Project Timeline',
          data: data,
          pointBackgroundColor: milestones.map(m => m.completed ? '#1cc88a' : '#4e73df'),
          pointBorderColor: milestones.map(m => m.completed ? '#169b6b' : '#2e59d9'),
          pointRadius: 10,
          pointHoverRadius: 12
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            type: 'time',
            time: {
              unit: 'month',
              displayFormats: {
                month: 'MMM yyyy'
              }
            },
            title: {
              display: true,
              text: 'Date'
            }
          },
          y: {
            reverse: true,
            ticks: {
              callback: function(value) {
                return labels[value];
              }
            },
            title: {
              display: true,
              text: 'Milestone'
            }
          }
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: function(context) {
                const milestone = milestones[context.dataIndex];
                const status = milestone.completed ? 'Completed' : 'Pending';
                const date = milestone.date.toLocaleDateString();
                return `${milestone.name} (${status}): ${date}`;
              }
            }
          }
        }
      }
    });
  }
  
  // Handle dynamic conditional fields
  function getProjectSpecificActivities(value) {
    const projectSpecificActivitiesDiv = document.getElementById('projectSpecificActivities');
    if (!projectSpecificActivitiesDiv) return;
    
    if (value === 'Yes') {
      projectSpecificActivitiesDiv.innerHTML = `
        <label for="fname">Please provide specific activities <span class="error">*</span></label>
        <textarea id="projectSpecificActivities" name="projectSpecificActivities" placeholder="" style="height:150px" class="required" required></textarea>
      `;
    } else {
      projectSpecificActivitiesDiv.innerHTML = '';
    }
  }
  
  function getOtherDonorsFunding(value) {
    const projectOtherDonorsFunding = document.getElementById('projectOtherDonorsFunding');
    if (!projectOtherDonorsFunding) return;
    
    if (value === 'Yes') {
      projectOtherDonorsFunding.innerHTML = `
        <label for="fname">State donor components<span class="error">*</span><br /></label>
        <table width="100%" border="0" id="POITable" class="donors-table">
          <tr>
            <th>Donor</th>
            <th>Amount</th>
            <th>&nbsp;</th>
          </tr>
          <tr>
            <td>
              <input type="text" name="StateDonors[]" id="donor1" class="required" minlength="5" required/>
            </td>
            <td>
              <input type="text" name="StateAmount[]" id="amount1" class="required" minlength="3" required/>
            </td>
            <td>
              <button type="button" class="btn-delete" onclick="deleteRow(this)" style="display:none;">Delete</button>
              <button type="button" class="btn-add" onclick="insRow()">Add Row</button>
            </td>
          </tr>
        </table>
      `;
    } else {
      projectOtherDonorsFunding.innerHTML = '';
    }
  }
  
  function getfurtheringWork(value) {
    const projectfurtheringWork = document.getElementById('projectfurtheringWork');
    if (!projectfurtheringWork) return;
    
    if (value === 'Yes') {
      projectfurtheringWork.innerHTML = `
        <label for="fname"><strong>Please indicate how</strong></label><br />
        <textarea id="furtheringWorkHow" name="furtheringWorkHow" placeholder="" style="height:150px" class="required" required></textarea>
      `;
    } else {
      projectfurtheringWork.innerHTML = '';
    }
  }
  
  function getWhyNoEthicalClearence(value) {
    const projectwhyNoNeedEthicalCliarence = document.getElementById('projectwhyNoNeedEthicalCliarence');
    if (!projectwhyNoNeedEthicalCliarence) return;
    
    if (value === 'No') {
      projectwhyNoNeedEthicalCliarence.style.display = 'block';
      const textarea = projectwhyNoNeedEthicalCliarence.querySelector('textarea');
      if (textarea) textarea.required = true;
    } else {
      projectwhyNoNeedEthicalCliarence.style.display = 'none';
      const textarea = projectwhyNoNeedEthicalCliarence.querySelector('textarea');
      if (textarea) textarea.required = false;
    }
  }
  
  function getResearchExperiece(value) {
    const researchExperiencediv = document.getElementById('researchExperiencediv');
    if (!researchExperiencediv) return;
    
    if (value === 'Yes') {
      researchExperiencediv.innerHTML = `
        <textarea id="ResearchExperienceDetails" name="ResearchExperienceDetails" placeholder="Please provide details of your research experience" style="height:150px" class="required" required></textarea>
      `;
    } else {
      researchExperiencediv.innerHTML = '';
    }
  }
  
  // Autocomplete team member search
  function showTeam(str) {
    if (str.length < 3) {
      document.getElementById('txtHintTeam').innerHTML = '';
      return;
    }
    
    // In a real implementation, this would make an AJAX call to the server
    // For demo purposes, simulate with sample data
    const sampleTeam = [
      { id: 1, name: 'John Smith', email: 'john.smith@example.com', expertise: 'Data Analysis' },
      { id: 2, name: 'Maria Johnson', email: 'maria.johnson@example.com', expertise: 'Molecular Biology' },
      { id: 3, name: 'Ahmed Hassan', email: 'ahmed.hassan@example.com', expertise: 'Statistical Modeling' },
      { id: 4, name: 'Susan Wong', email: 'susan.wong@example.com', expertise: 'Clinical Research' }
    ];
    
    // Filter the sample team based on the search string
    const filteredTeam = sampleTeam.filter(member => 
      member.name.toLowerCase().includes(str.toLowerCase()) || 
      member.email.toLowerCase().includes(str.toLowerCase())
    );
    
    // Create HTML for search results
    let html = '<div class="search-results">';
    
    if (filteredTeam.length > 0) {
      html += '<ul>';
      filteredTeam.forEach(member => {
        html += `<li>
          <a href="#" onclick="selectTeamMember(${member.id}, '${member.name}'); return false;">
            <strong>${member.name}</strong><br>
            <small>${member.email} - ${member.expertise}</small>
          </a>
        </li>`;
      });
      html += '</ul>';
    } else {
      html += '<p>No matching team members found.</p>';
    }
    
    html += '</div>';
    
    document.getElementById('txtHintTeam').innerHTML = html;
  }
  
  function selectTeamMember(id, name) {
    document.getElementById('EnterTeamMember').value = name;
    document.getElementById('EnterTeamMemberSelected').value = id;
    document.getElementById('txtHintTeam').innerHTML = '';
  }
  
  // Calculate budget totals
  function calculateBudgetTotals() {
    // Get all budget input elements
    const personnelInput = document.getElementById('Personnel');
    const researchCostsInput = document.getElementById('ResearchCosts');
    const equipmentInput = document.getElementById('Equipment');
    const travelInput = document.getElementById('Travel');
    const kickoffInput = document.getElementById('kickoff');
    const knowledgeSharingInput = document.getElementById('KnowledgeSharing');
    const overheadCostsInput = document.getElementById('OverheadCosts');
    const otherGoodsInput = document.getElementById('OtherGoods');
    const matchingSupportInput = document.getElementById('MatchingSupport');
    const totalSubmittedInput = document.getElementById('TotalSubmitted');
    
    // Calculate total if all fields exist
    if (personnelInput && researchCostsInput && equipmentInput && travelInput && 
        kickoffInput && knowledgeSharingInput && overheadCostsInput && 
        otherGoodsInput && matchingSupportInput && totalSubmittedInput) {
      
      // Parse input values
      const personnel = parseFloat(personnelInput.value) || 0;
      const researchCosts = parseFloat(researchCostsInput.value) || 0;
      const equipment = parseFloat(equipmentInput.value) || 0;
      const travel = parseFloat(travelInput.value) || 0;
      const kickoff = parseFloat(kickoffInput.value) || 0;
      const knowledgeSharing = parseFloat(knowledgeSharingInput.value) || 0;
      const overheadCosts = parseFloat(overheadCostsInput.value) || 0;
      const otherGoods = parseFloat(otherGoodsInput.value) || 0;
      const matchingSupport = parseFloat(matchingSupportInput.value) || 0;
      
      // Calculate total
      const total = personnel + researchCosts + equipment + travel + kickoff + 
                    knowledgeSharing + overheadCosts + otherGoods + matchingSupport;
      
      // Update total field
      totalSubmittedInput.value = total.toFixed(2);
      
      // Update chart if it exists
      if (document.getElementById('budgetPieChart')) {
        initBudgetCharts();
      }
    }
  }
  
  // Add event listeners to budget inputs for automatic calculations
  document.addEventListener('DOMContentLoaded', function() {
    const budgetInputs = [
      'Personnel', 'ResearchCosts', 'Equipment', 'Travel', 'kickoff', 
      'KnowledgeSharing', 'OverheadCosts', 'OtherGoods', 'MatchingSupport'
    ];
    
    budgetInputs.forEach(inputId => {
      const input = document.getElementById(inputId);
      if (input) {
        input.addEventListener('input', calculateBudgetTotals);
      }
    });
  });