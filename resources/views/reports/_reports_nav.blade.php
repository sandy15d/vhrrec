<style>
    /*     .reportlists {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .reportlists li.active {
        font-family: 'Roboto-Bold';
        background: #dceeff;
    }

    .reportlists li {
        display: inline-block;
    }

    .reportlists li a {
        color: #444;
        padding: 10px 5px;
        display: block;
    }

    a {
        position: relative;
        overflow: hidden;
        display: table;
    } */
    .active {

        background: #dceeff;
    }

</style>

<div class="card border-top border-0 border-4 border-success mb-1">
    <div class="card-body">
        <div class="row">
            <div class="col p-2 {{ session('submenu') == 'mrfs_report' ? 'active' : '' }} ">
                <a href="/mrfs_report">MRF Details</a>
            </div>

            <div class="col p-2 {{ session('submenu') == 'application_source_report' ? 'active' : '' }}">
                <a href="/application_source_report">Application Source</a>
            </div>

            <div class="col p-2 {{ session('submenu') == 'hr_screening_report' ? 'active' : '' }}">
                <a href="/hr_screening_report">HR Screening</a>
            </div>

            <div class="col p-2 {{ session('submenu') == 'tech_screening_report' ? 'active' : '' }}">
                <a href="/tech_screening_report">Tech. Screening</a>
            </div>

            <div class="col p-2 {{ session('submenu') == 'interview_tracker_report' ? 'active' : '' }}">
                <a href="/interview_tracker_report">Interview Tracker</a>
            </div>

            <div class="col p-2 {{ session('submenu') == 'job_offer_report' ? 'active' : '' }}">
                <a href="/job_offer_report">Job Offers</a>
            </div>
            
            <div class="col p-2 {{ session('submenu') == 'candidate_joining_report' ? 'active' : '' }}">
                <a href="/candidate_joining_report">Candidates Joined</a>
            </div>
            </ul>
        </div>
    </div>
</div>
