// Screen History Stack
let screenHistory = ['homeScreen'];

// --- GLOBAL SELECTION HELPERS ---
let currentSelection = null;

function selectOption(character, option) {
    currentSelection = option;

    // UI Update: Highlight the selected button
    let prefix = '';
    if (character === 'tokyo') prefix = 'tm';
    else if (character === 'denver') prefix = 'dm';
    else if (character === 'rio') prefix = 'rm';

    const btnA = document.getElementById(prefix + 'PlanA');
    const btnB = document.getElementById(prefix + 'PlanB');

    // Remove active/selected class first
    btnA.classList.remove('selected');
    btnB.classList.remove('selected');

    // Add to clicked
    if (option === 'A') btnA.classList.add('selected');
    if (option === 'B') btnB.classList.add('selected');
}

function resetSelectionUI(prefix) {
    currentSelection = null;
    const btnA = document.getElementById(prefix + 'PlanA');
    const btnB = document.getElementById(prefix + 'PlanB');
    if (btnA) btnA.classList.remove('selected');
    if (btnB) btnB.classList.remove('selected');
}

function updateResultScreen(character, choices) {
    let resultList = document.querySelector('#' + character + 'ResultScreen .result-list');
    if (resultList) {
        resultList.innerHTML =
            `PLANNING : ${choices.PLANNING || '-'}<br>` +
            `EXECUTION : ${choices.EXECUTION || '-'}<br>` +
            `NEGOTIATION : ${choices.NEGOTIATION || '-'}<br>` +
            `ESCAPE : ${choices.ESCAPE || '-'}`;
    }
}
// --------------------------------

function showScreen(screenId, addToHistory = true) {
    document.querySelectorAll('.screen').forEach(screen => {
        screen.classList.remove('active');
    });
    const targetScreen = document.getElementById(screenId);
    if (targetScreen) {
        targetScreen.classList.add('active');

        // Add to history if new and not strictly back navigation
        if (addToHistory && screenId !== screenHistory[screenHistory.length - 1]) {
            screenHistory.push(screenId);
        }
    }
}

function goBack() {
    if (screenHistory.length > 1) {
        screenHistory.pop(); // Remove current screen
        const previousScreen = screenHistory[screenHistory.length - 1];
        showScreen(previousScreen, false); // Don't push previous screen again
    } else {
        // Default fallback if history is empty (shouldn't happen)
        showScreen('chooseRoleScreen');
    }
}

function goToHome() {
    showScreen('homeScreen');
    screenHistory = ['homeScreen']; // Reset history
}

function goToRegister() {
    showScreen('registerScreen');
}

function goToChooseRole() {
    showScreen('chooseRoleScreen');
}

function handleRegister(event) {
    event.preventDefault();
    showScreen('chooseRoleScreen');
    return false;
}

function selectRole(role) {
    sessionStorage.setItem('selectedRole', role);
    if (role === 'professor') {
        showScreen('professorLoginScreen');
    } else if (role === 'tokyo') {
        showScreen('tokyoLoginScreen');
    } else if (role === 'denver') {
        showScreen('denverLoginScreen');
    } else if (role === 'rio') {
        showScreen('rioLoginScreen');
    } else {
        alert(role.toUpperCase() + ' - Crew Landing coming next!');
    }
}

function handleProfessorLogin(event) {
    event.preventDefault();
    showScreen('professorLandingScreen');
    return false;
}

function handleTokyoLogin(event) {
    event.preventDefault();
    // alert('Tokyo Login Successful! (Dashboard coming soon)');
    showScreen('tokyoLandingScreen');
    return false;
}

function handleDenverLogin(event) {
    event.preventDefault();
    // alert('Denver Login Coming Soon!');
    showScreen('denverLandingScreen');
    return false;
}

function handleRioLogin(event) {
    event.preventDefault();
    // alert('Rio Login Coming Soon!');
    showScreen('rioLandingScreen');
    return false;
}

/* RIO MISSION LOGIC */
let rioMissionPhase = 'PLANNING';
let rioChoices = { PLANNING: null, EXECUTION: null, NEGOTIATION: null, ESCAPE: null };

function goToRioMission() {
    rioMissionPhase = 'PLANNING';
    document.getElementById('rmPhaseTitle').innerText = 'PILIH RENCANA : PLANNING';
    document.getElementById('rmPlanA').innerText = 'PLAN A : HACK SISTEM CCTV DAN ALARM';
    document.getElementById('rmPlanB').innerText = 'PLAN B : JAMMING FREKUENSI POLISI';
    resetSelectionUI('rm');
    showScreen('rioMissionScreen');
}

function handleRioMissionSubmit() {
    if (!currentSelection) {
        alert('PILIH RENCANA TERLEBIH DAHULU!');
        return;
    }
    rioChoices[rioMissionPhase] = currentSelection;
    // alert('Opsi Dikirim: PLAN ' + currentSelection);

    if (rioMissionPhase === 'PLANNING') {
        rioMissionPhase = 'EXECUTION';
        document.getElementById('rmPhaseTitle').innerText = 'PILIH RENCANA : EXECUTION';
        document.getElementById('rmPlanA').innerText = 'PLAN A : LAKUKAN TEMBAKAN PERINGATAN';
        document.getElementById('rmPlanB').innerText = 'PLAN B : GENKAN TOPENG DALI';
        resetSelectionUI('rm');
    } else if (rioMissionPhase === 'EXECUTION') {
        rioMissionPhase = 'NEGOTIATION';
        document.getElementById('rmPhaseTitle').innerText = 'PILIH RENCANA : NEGOTIATION';
        document.getElementById('rmPlanA').innerText = 'PLAN A : TEWASKAN 2 SANDERA';
        document.getElementById('rmPlanB').innerText = 'PLAN B : MEMINTA PERPANJANGAN WAKTU';
        resetSelectionUI('rm');
    } else if (rioMissionPhase === 'NEGOTIATION') {
        rioMissionPhase = 'ESCAPE';
        document.getElementById('rmPhaseTitle').innerText = 'PILIH RENCANA : ESCAPE';
        document.getElementById('rmPlanA').innerText = 'PLAN A : LEDAKAN PINTU DEPAN';
        document.getElementById('rmPlanB').innerText = 'PLAN B : LEWATI TEROWONGNA TERSEMBUNYI';
        resetSelectionUI('rm');
    } else if (rioMissionPhase === 'ESCAPE') {
        updateResultScreen('rio', rioChoices);
        showScreen('rioResultScreen');
        resetSelectionUI('rm');
    }
}

function handleRioBack() {
    if (rioMissionPhase === 'ESCAPE') {
        rioMissionPhase = 'NEGOTIATION';
        document.getElementById('rmPhaseTitle').innerText = 'PILIH RENCANA : NEGOTIATION';
        document.getElementById('rmPlanA').innerText = 'PLAN A : TEWASKAN 2 SANDERA';
        document.getElementById('rmPlanB').innerText = 'PLAN B : MEMINTA PERPANJANGAN WAKTU';
    } else if (rioMissionPhase === 'NEGOTIATION') {
        rioMissionPhase = 'EXECUTION';
        document.getElementById('rmPhaseTitle').innerText = 'PILIH RENCANA : EXECUTION';
        document.getElementById('rmPlanA').innerText = 'PLAN A : LAKUKAN TEMBAKAN PERINGATAN';
        document.getElementById('rmPlanB').innerText = 'PLAN B : GENKAN TOPENG DALI';
    } else if (rioMissionPhase === 'EXECUTION') {
        rioMissionPhase = 'PLANNING';
        document.getElementById('rmPhaseTitle').innerText = 'PILIH RENCANA : PLANNING';
        document.getElementById('rmPlanA').innerText = 'PLAN A : HACK SISTEM CCTV DAN ALARM';
        document.getElementById('rmPlanB').innerText = 'PLAN B : JAMMING FREKUENSI POLISI';
    } else {
        goBack();
    }
}

function goToCreateMission() {
    showScreen('createMissionScreen');
}

function goToProfessorLanding() {
    showScreen('professorLandingScreen');
}

function goToLiveMonitor() {
    showScreen('liveMonitorScreen');
}

function goToTokyoMission() {
    // Reset phase when entering screen
    tokyoMissionPhase = 'PLANNING';
    document.getElementById('tmPhaseTitle').innerText = 'PILIH RENCANA : PLANNING';
    document.getElementById('tmPlanA').innerText = 'PLAN A : HACK SISTEM CCTV DAN ALARM';
    document.getElementById('tmPlanB').innerText = 'PLAN B : JAMMING FREKUENSI POLISI';
    showScreen('tokyoMissionScreen');
}

function goToTokyoLanding() {
    showScreen('tokyoLandingScreen');
}

// Tokyo Phase State
let tokyoMissionPhase = 'PLANNING';
let tokyoChoices = { PLANNING: null, EXECUTION: null, NEGOTIATION: null, ESCAPE: null };

function handleTokyoMissionSubmit() {
    if (!currentSelection) {
        alert('PILIH RENCANA TERLEBIH DAHULU!');
        return;
    }

    // Save Choice
    tokyoChoices[tokyoMissionPhase] = currentSelection;
    // Show Feedback (Optional)
    // alert('Opsi Dikirim: PLAN ' + currentSelection);

    if (tokyoMissionPhase === 'PLANNING') {
        tokyoMissionPhase = 'EXECUTION';
        document.getElementById('tmPhaseTitle').innerText = 'PILIH RENCANA : EXECUTION';
        document.getElementById('tmPlanA').innerText = 'PLAN A : LAKUKAN TEMBAKAN PERINGATAN';
        document.getElementById('tmPlanB').innerText = 'PLAN B : GENKAN TOPENG DALI';
        resetSelectionUI('tm');
    } else if (tokyoMissionPhase === 'EXECUTION') {
        tokyoMissionPhase = 'NEGOTIATION';
        document.getElementById('tmPhaseTitle').innerText = 'PILIH RENCANA : NEGOTIATION';
        document.getElementById('tmPlanA').innerText = 'PLAN A : TEWASKAN 2 SANDERA';
        document.getElementById('tmPlanB').innerText = 'PLAN B : MEMINTA PERPANJANGAN WAKTU';
        resetSelectionUI('tm');
    } else if (tokyoMissionPhase === 'NEGOTIATION') {
        tokyoMissionPhase = 'ESCAPE';
        document.getElementById('tmPhaseTitle').innerText = 'PILIH RENCANA : ESCAPE';
        document.getElementById('tmPlanA').innerText = 'PLAN A : LEDAKAN PINTU DEPAN';
        document.getElementById('tmPlanB').innerText = 'PLAN B : LEWATI TEROWONGNA TERSEMBUNYI';
        resetSelectionUI('tm');
    } else if (tokyoMissionPhase === 'ESCAPE') {
        updateResultScreen('tokyo', tokyoChoices);
        showScreen('tokyoResultScreen');
        resetSelectionUI('tm');
    }
}

function handleTokyoBack() {
    if (tokyoMissionPhase === 'ESCAPE') {
        // Revert Escape -> Negotiation
        tokyoMissionPhase = 'NEGOTIATION';
        document.getElementById('tmPhaseTitle').innerText = 'PILIH RENCANA : NEGOTIATION';
        document.getElementById('tmPlanA').innerText = 'PLAN A : TEWASKAN 2 SANDERA';
        document.getElementById('tmPlanB').innerText = 'PLAN B : MEMINTA PERPANJANGAN WAKTU';
    } else if (tokyoMissionPhase === 'NEGOTIATION') {
        // Revert Negotiation -> Execution
        tokyoMissionPhase = 'EXECUTION';
        document.getElementById('tmPhaseTitle').innerText = 'PILIH RENCANA : EXECUTION';
        document.getElementById('tmPlanA').innerText = 'PLAN A : LAKUKAN TEMBAKAN PERINGATAN';
        document.getElementById('tmPlanB').innerText = 'PLAN B : GENKAN TOPENG DALI';
    } else if (tokyoMissionPhase === 'EXECUTION') {
        // Revert Execution -> Planning
        tokyoMissionPhase = 'PLANNING';
        document.getElementById('tmPhaseTitle').innerText = 'PILIH RENCANA : PLANNING';
        document.getElementById('tmPlanA').innerText = 'PLAN A : HACK SISTEM CCTV DAN ALARM';
        document.getElementById('tmPlanB').innerText = 'PLAN B : JAMMING FREKUENSI POLISI';
    } else {
        // Normal Back
        goBack();
    }
}

// Denver Logic
let denverMissionPhase = 'PLANNING';
let denverChoices = { PLANNING: null, EXECUTION: null, NEGOTIATION: null, ESCAPE: null };

function goToDenverMission() {
    denverMissionPhase = 'PLANNING';
    document.getElementById('dmPhaseTitle').innerText = 'PILIH RENCANA : PLANNING';
    document.getElementById('dmPlanA').innerText = 'PLAN A : HACK SISTEM CCTV DAN ALARM';
    document.getElementById('dmPlanB').innerText = 'PLAN B : JAMMING FREKUENSI POLISI';
    resetSelectionUI('dm');
    showScreen('denverMissionScreen');
}

function handleDenverMissionSubmit() {
    if (!currentSelection) {
        alert('PILIH RENCANA TERLEBIH DAHULU!');
        return;
    }
    denverChoices[denverMissionPhase] = currentSelection;
    // alert('Opsi Dikirim: PLAN ' + currentSelection);

    if (denverMissionPhase === 'PLANNING') {
        denverMissionPhase = 'EXECUTION';
        document.getElementById('dmPhaseTitle').innerText = 'PILIH RENCANA : EXECUTION';
        document.getElementById('dmPlanA').innerText = 'PLAN A : LAKUKAN TEMBAKAN PERINGATAN';
        document.getElementById('dmPlanB').innerText = 'PLAN B : GENKAN TOPENG DALI';
        resetSelectionUI('dm');
    } else if (denverMissionPhase === 'EXECUTION') {
        denverMissionPhase = 'NEGOTIATION';
        document.getElementById('dmPhaseTitle').innerText = 'PILIH RENCANA : NEGOTIATION';
        document.getElementById('dmPlanA').innerText = 'PLAN A : TEWASKAN 2 SANDERA';
        document.getElementById('dmPlanB').innerText = 'PLAN B : MEMINTA PERPANJANGAN WAKTU';
        resetSelectionUI('dm');
    } else if (denverMissionPhase === 'NEGOTIATION') {
        denverMissionPhase = 'ESCAPE';
        document.getElementById('dmPhaseTitle').innerText = 'PILIH RENCANA : ESCAPE';
        document.getElementById('dmPlanA').innerText = 'PLAN A : LEDAKAN PINTU DEPAN';
        document.getElementById('dmPlanB').innerText = 'PLAN B : LEWATI TEROWONGNA TERSEMBUNYI';
        resetSelectionUI('dm');
    } else if (denverMissionPhase === 'ESCAPE') {
        updateResultScreen('denver', denverChoices);
        showScreen('denverResultScreen');
        resetSelectionUI('dm');
    }
}

function handleDenverBack() {
    if (denverMissionPhase === 'ESCAPE') {
        denverMissionPhase = 'NEGOTIATION';
        document.getElementById('dmPhaseTitle').innerText = 'PILIH RENCANA : NEGOTIATION';
        document.getElementById('dmPlanA').innerText = 'PLAN A : TEWASKAN 2 SANDERA';
        document.getElementById('dmPlanB').innerText = 'PLAN B : MEMINTA PERPANJANGAN WAKTU';
    } else if (denverMissionPhase === 'NEGOTIATION') {
        denverMissionPhase = 'EXECUTION';
        document.getElementById('dmPhaseTitle').innerText = 'PILIH RENCANA : EXECUTION';
        document.getElementById('dmPlanA').innerText = 'PLAN A : LAKUKAN TEMBAKAN PERINGATAN';
        document.getElementById('dmPlanB').innerText = 'PLAN B : GENKAN TOPENG DALI';
    } else if (denverMissionPhase === 'EXECUTION') {
        denverMissionPhase = 'PLANNING';
        document.getElementById('dmPhaseTitle').innerText = 'PILIH RENCANA : PLANNING';
        document.getElementById('dmPlanA').innerText = 'PLAN A : HACK SISTEM CCTV DAN ALARM';
        document.getElementById('dmPlanB').innerText = 'PLAN B : JAMMING FREKUENSI POLISI';
    } else {
        goBack();
    }
}

// Live Monitor Content Data
const missionData = {
    1: {
        title: "PHASE 1 :<br>PLANNING",
        desc: "TIM BERSIAP MEMBOBOL SISTEM.<br>PILIH INSTRUKSI PROFESSOR",
        optionA: "HACK SISTEM CCTV DAN ALARM",
        optionB: "JAMMING FREKUENSI POLISI",
        icon: `<svg width="80" height="140" viewBox="0 0 80 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="5" y="5" width="70" height="130" rx="10" stroke="#800000" stroke-width="8" fill="#1a1a1a"/>
                        <path d="M25 70 L35 80 L55 50" stroke="#800000" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                       </svg>`
    },
    2: {
        title: "PHASE 2 :<br>EXECUTION",
        desc: "POLISI MENGEPUNG PINTU DEPAN<br>LAKUKAN TAKTIK BERTAHAN",
        optionA: "LAKUKAN TEMBAKAN PERINGATAN",
        optionB: "GUNAKAN TOPENG DALI ( CONFUSION )",
        icon: `<svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="10" y="10" width="80" height="80" rx="15" fill="#800000"/>
                        <path d="M30 50 L45 65 L70 35" stroke="#1a1a1a" stroke-width="12" stroke-linecap="round" stroke-linejoin="round"/>
                       </svg>`
    },
    3: {
        title: "PHASE 3 :<br>NEGOTIATION",
        desc: "INSPEKTUR MEMINTA BUKTI<br>KEHIDUPAN SANDERA",
        optionA: "TEWASKAN 2 SANDERA",
        optionB: "MEMINTA PERPANJANGAN WAKTU",
        icon: `<svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="35" r="15" stroke="#800000" stroke-width="8" />
                        <path d="M20 80 Q50 40 80 80" stroke="#800000" stroke-width="8" stroke-linecap="round" fill="none" />
                        <line x1="20" y1="80" x2="80" y2="80" stroke="#800000" stroke-width="8" stroke-linecap="round" />
                       </svg>`
    },
    4: {
        title: "PHASE 4 :<br>ESCAPE",
        desc: "PENCURIAN BERHASIL.<br>WAKTUNYA MELARIKAN DIRI",
        optionA: "LEDAKAN PINTU DEPAN",
        optionB: "LEWATI TEROWONGAN TERSEMBUNYI",
        icon: `<svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="20" r="10" fill="#800000" />
                        <path d="M50 30 L50 60" stroke="#800000" stroke-width="8" stroke-linecap="round" />
                        <path d="M50 35 L30 50 M50 35 L70 50" stroke="#800000" stroke-width="8" stroke-linecap="round" />
                        <path d="M50 60 L35 90 M50 60 L65 90" stroke="#800000" stroke-width="8" stroke-linecap="round" />
                       </svg>`
    }
};

function switchPhase(phaseId) {
    // Update Active Button
    document.querySelectorAll('.timeline-btn').forEach((btn, index) => {
        if (index + 1 === phaseId) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    // Update Content
    const data = missionData[phaseId];
    if (data) {
        document.getElementById('phaseTitle').innerHTML = data.title;
        document.getElementById('phaseDesc').innerHTML = data.desc;
        document.getElementById('phaseIcon').innerHTML = data.icon;
        document.getElementById('optionInputA').innerText = data.optionA;
        document.getElementById('optionInputB').innerText = data.optionB;
    }
}

function showMissionCreatedModal() {
    const modal = document.getElementById('missionCreatedModal');
    if (modal) {
        modal.classList.add('active');
    }
}

function hideMissionCreatedModal() {
    const modal = document.getElementById('missionCreatedModal');
    if (modal) {
        modal.classList.remove('active');
    }
}
