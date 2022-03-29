<?php
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <?php require_once './includes/components/topNav.php';?>
        <section class="content">
            <div class="top-title d-flex justify-content-between full-width align-items-center">
                <div class="">
                    <h2 class="title p3"><?= $data['project'] ?></h2>
                </div>
                <!-- <a href="/projects/add" class="btn">Approve this project</a> -->
            </div>
            <hr>
            <div class="row mt-4 proj-info">
                <div class="project_info_top d-flex">
                    <div class=" col-md-6">
                        <div>
                            <span class="d-block p-name mb-2">Construction Type</span>
                            <span class="p-data">
                                <?= $data['projectMetricsData'][0]['Construction_Type']?>
                            </span>
                        </div>

                        <div class="details">
                            <span class="d-block p-name mt-3 mb-2">Project Sector</span>
                            <span id="sect" class="p-data">
                                <?= $data['projectMetricsData'][0]['sector']?>
                            </span>
                        </div>

                        <div class="details">
                            <span class="d-block p-name mt-3 mb-2">Project Start Year</span>
                            <span class="p-data">
                                <?= $data['projectData'][0]['startYear']?>
                            </span>
                        </div>

                        <div class="details">
                            <span class="d-block p-name mt-3 mb-2">Project State</span>
                            <span class="p-data">
                                <?= $data['projectData'][0]['origin_state']?>

                            </span>
                        </div>
                        <div class="details">
                            <span class="d-block p-name mt-3 mb-2">Project LGA</span>
                            <span class="p-data">
                                <?= $data['projectData'][0]['origin_lga']?>
                            </span>
                        </div>

                        <div>
                            <span class="d-block p-name mt-3 mb-2">Description:</span>
                            <P class="p-data">
                                <?= $data['projectData'][0]['description']?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center p-score">
                        <div class="box">
                            <div class="circular-progress">
                                <div class="value-container hidden">
                                    <%= project.projScore %>
                                </div>
                            </div>
                            <p class="rank text-center mt-4">Rank - <span id="rank">-</span>/<span id="total"
                                    class="tiny">-</span></p>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h2 class="mb-4 assess-cat">Assessment Categories</h2>
                <div class="d-flex flex-column col-md-6 cat-set">
                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% let val=project.catWeights[cType[0]] %>
                                <!-- <% let input=project.catInputs[cType[0]] %> -->
                                <% let max=0 %>
                                    <% if (sector=="Highway Construction" ) { max=20 %>
                                        Construction Type: <span class="selections">
                                            <%= val %>/20
                                        </span>
                                        <% } else if (sector=="Railway Construction" ) { max=40 %>
                                            Construction Type: <span class="selections">
                                                <%= val %>/40
                                            </span>
                                            <% } %>
                        </span>
                        <meter class="bar mb-3" value="<%= val %>" min="0" max="<%= max %>"></meter>
                    </div>
                    <span class="d-block p-name mt-3 mb-4">Technical Considerations</span>
                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% val=project.numWeights[nType[0]] %>
                                <% input=project.numInputs[nType[0]] %>
                                    <% if (sector=="Highway Construction" ) { %>
                                        Average Daily Traffic: <span class="selections">
                                            <%= input %> (<%= val %>/40)
                                        </span>
                                        <% } else if (sector=="Railway Construction" ) { %>
                                            Average Daily Customers: <span class="selections">
                                                <%= input %> (<%= val %>/40)
                                            </span>
                                            <% } %>
                        </span>
                        <meter class="bar mb-3" value="<%= val %>" min="0" max="40"></meter>
                    </div>

                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% input=project.numInputs.volCap %>
                                Volume-to-capacity Ratio: <span class="selections">
                                    <%= input %> (<%= project.numWeights.volCap %>/30)
                                </span>
                        </span>
                        <meter class="bar mb-3" value="<%= project.numWeights.volCap %>" min="0" max="30"></meter>
                    </div>

                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% val=project.catWeights[cType[1]] %>
                                <% input=project.catInputs[cType[1]] %>
                                    <% if (sector=="Highway Construction" ) { %>
                                        Roadway Classification: <span class="selections">
                                            <%= input %> (<%= val %>/30)
                                        </span>
                                        <% } else if (sector=="Railway Construction" ) { %>
                                            Railway Classification: <span class="selections">
                                                <%= input %> (<%= val %>/30)
                                            </span>
                                            <% } %>
                        </span>
                        <meter class="bar mb-3" value="<%= val %>" min="0" max="30"></meter>
                    </div>

                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% val=project.catWeights[cType[2]] %>
                                <% input=project.catInputs[cType[2]] %>
                                    <% if (sector=="Highway Construction" ) { max=15 %>
                                        MacroCorridor Completion: <span class="selections">
                                            <%= input %> (<%=val%>/15)
                                        </span>
                                        <% } else if (sector=="Railway Construction" ) { max=20 %>
                                            MacroCorridor Completion: <span class="selections">
                                                <%= input %> (<%=val%>/20)
                                            </span>
                                            <% } %>
                        </span>
                        <meter class="bar mb-3" value="<%= val %>" min="0" max="<%= max %>"></meter>
                    </div>

                    <% if (sector=="Highway Construction" ) { %>
                        <div class="details w-100">
                            <span class="d-block mb-1 metric">
                                <% input=project.numInputs.accidentRate %>
                                    Accident Rate: <span class="selections">
                                        <%= input %> (<%= project.numWeights.accidentRate %>/25)
                                    </span>
                            </span>
                            <meter class="bar mb-3" value="<%= project.numWeights.accidentRate %>" min="0"
                                max="25"></meter>
                        </div>
                        <% } %>

                            <span class="d-block p-name mt-3 mb-4">Socio - Economic Development</span>
                            <div class="details w-100">
                                <span class="d-block mb-1 metric">
                                    <% input=project.numInputs.jobsCreated %>
                                        Number of Jobs Created:
                                        <span class="selections">
                                            <%= input %> (<%= project.numWeights.jobsCreated %>/20)
                                        </span>
                                </span>
                                <meter class="bar mb-3" value="<%= project.numWeights.jobsCreated %>" min="0"
                                    max="20"></meter>
                            </div>
                            <div class="details w-100">
                                <span class="d-block mb-1 metric">
                                    <% input=project.numInputs.retJobs %>
                                        No. of Jobs that would be retained:
                                        <span class="selections">
                                            <%= input %> (<%= project.numWeights.retJobs %>/15)
                                        </span>
                                </span>
                                <meter class="bar mb-3" value="<%= project.numWeights.retJobs %>" min="0"
                                    max="15"></meter>
                            </div>
                            <div class="details w-100">
                                <span class="d-block mb-1 metric">
                                    <% input=project.numInputs.gdp %>
                                        Gross Domestic Product:
                                        <span class="selections">
                                            <%= input %> (<%= project.numWeights.gdp %>/5)
                                        </span>
                                </span>
                                <meter class="bar mb-3" value="<%= project.numWeights.gdp %>" min="0" max="5"></meter>
                            </div>
                            <div class="details w-100">
                                <span class="d-block mb-1 metric">
                                    <% input=project.numInputs.costEff%>
                                        Cost Effectiveness:
                                        <span class="selections">
                                            <%= input %> (<%= project.numWeights.costEff %>/15)
                                        </span>
                                </span>
                                <meter class="bar mb-3" value="<%= project.numWeights.costEff %>" min="0"
                                    max="15"></meter>
                            </div>
                            <div class="details w-100">
                                <span class="d-block mb-1 metric">
                                    <% input=project.numInputs.projCost %>
                                        Level of Investment:
                                        <span class="selections">
                                            <%= input %> (<%= project.numWeights.projCost %>/15)
                                        </span>
                                </span>
                                <meter class="bar mb-3" value="<%= project.numWeights.projCost %>" min="0"
                                    max="15"></meter>
                            </div>
                            <div class="details w-100">
                                <span class="d-block mb-1 metric">
                                    <% input=project.numInputs.payback %>
                                        Payback Period:
                                        <span class="selections">
                                            <%= input %> (<%= project.numWeights.payback %>/20)
                                        </span>
                                </span>
                                <meter class="bar mb-3" value="<%= project.numWeights.payback %>" min="0"
                                    max="20"></meter>
                            </div>
                            <div class="details w-100">
                                <span class="d-block mb-1 metric">
                                    <% input=project.catInputs.compRel %>
                                        Compensation and Relocation: <span class="selections">
                                            <%= input %> (<%= project.catWeights.compRel %>/10)
                                        </span>
                                </span>
                                <meter class="bar mb-3" value="<%= project.catWeights.compRel %>" min="0"
                                    max="10"></meter>
                            </div>
                            <div class="details w-100">
                                <span class="d-block mb-1 metric">
                                    <% input=project.numInputs.popServe %>
                                        Population to be served:
                                        <span class="selections">
                                            <%= input %> (<%= project.numWeights.popServe %>/20)
                                        </span>
                                </span>
                                <meter class="bar mb-3" value="<%= project.numWeights.popServe %>" min="0"
                                    max="20"></meter>
                            </div>

                </div>

                <div class="d-flex flex-column col-md-6 cat-set">
                    <span class="d-block p-name mb-3">Regional Integration</span>
                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% input=project.catInputs.interReg %>
                                Enhances inter-regional trade:
                                <span class="selections">
                                    <%= input %> (<%= project.catWeights.interReg %>/30)
                                </span>
                        </span>
                        <meter class="bar mb-3" value="<%= project.catWeights.interReg %>" min="0" max="30"></meter>
                    </div>
                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% input=project.catInputs.econBenefits %>
                                Links other regions:
                                <span class="selections">
                                    <%= input %> (<%= project.catWeights.econBenefits %>/10)
                                </span>
                        </span>
                        <meter class="bar mb-3" value="<%= project.catWeights.econBenefits %>" min="0" max="10"></meter>
                    </div>
                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% input=project.catInputs.jobOpp %>
                                Job opportunities for different
                                regions: <span class="selections">
                                    <%= input %> (<%= project.catWeights.jobOpp %>/10)
                                </span>
                        </span>
                        <meter class="bar mb-3" value="<%= project.catWeights.jobOpp %>" min="0" max="10"></meter>
                    </div>

                    <span class="d-block p-name mt-3 mb-4">Environmental Considerations</span>
                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% val=project.catWeights[cType[7]] %>
                                <% input=project.catInputs[cType[7]] %>
                                    Mitigate against environmental degradation: <span class="selections">
                                        <%= input %> (<%= val %>/10)
                                    </span>
                        </span>
                        <meter class="bar mb-3" value="<%= val %>" min="0" max="10"></meter>
                    </div>

                    <div class="details w-100">
                        <span class="d-block mb-1 metric">Amount of Co2 Emmissions:
                            <%= project.numWeights.co2 %>/15
                        </span>
                        <meter class="bar mb-3" value="<%= project.numWeights.co2 %>" min="0" max="15"></meter>
                    </div>

                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% input=project.catInputs.envImpact %>
                                Environmental Impact:
                                <span class="selections">
                                    <%= input %> (<%= project.catWeights.envImpact %>/20)
                                </span>
                        </span>
                        <meter class="bar mb-3" value="<%= project.catWeights.envImpact %>" min="0" max="20"></meter>
                    </div>
                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% input=project.catInputs.wasteMgt %>
                                Waste Management:
                                <span class="selections">
                                    <%= input %> (<%= project.catWeights.wasteMgt %>/10)
                                </span>
                        </span>
                        <meter class="bar mb-3" value="<%= project.catWeights.wasteMgt %>" min="0" max="10"></meter>
                    </div>
                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% input=project.catInputs.ohs %>
                                Occupational Health and Safety:
                                <span class="selections">
                                    <%= input %> (<%= project.catWeights.ohs %>/10)
                                </span>
                        </span>
                        <meter class="bar mb-3" value="<%= project.catWeights.ohs %>" min="0" max="10"></meter>
                    </div>
                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% input=project.catInputs.natMat %>
                                Use of naturally occuring materials:
                                <span class="selections">
                                    <%= input %> (<%= project.catWeights.natMat %>/5)
                                </span>
                        </span>
                        <meter class="bar mb-3" value="<%= project.catWeights.natMat %>" min="0" max="5"></meter>
                    </div>

                    <span class="d-block p-name mt-3 mb-3">Funding</span>
                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% input=project.catInputs.ppp %>
                                Private/Public/Local Participation:
                                <span class="selections">
                                    <%= input %> (<%= project.catWeights.ppp %>/40)
                                </span>
                        </span>
                        <meter class="bar mb-3" value="<%= project.catWeights.ppp  %>" min="0" max="40"></meter>
                    </div>

                    <span class="d-block p-name mt-4 mb-3">Intermodal Connectivity</span>
                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% val=project.catWeights[cType[13]] %>
                                <% input=project.catInputs[cType[13]] %>
                                    <% if (sector=="Highway Construction" ) { max=20 %>
                                        Unique Multimodal Impacts: <span class="selections">
                                            <%= input %> (<%= val %>/20)
                                        </span>
                                        <% } else if (sector=="Railway Construction" ) { max=40 %>
                                            Unique Multimodal Impacts: <span class="selections">
                                                <%= input %> (<%= val %>/40)
                                            </span>
                                            <% } %>
                        </span>
                        <meter class="bar mb-3" value="<%= val %>" min="0" max="<%= val %>"></meter>
                    </div>

                    <span class="d-block p-name mt-3 mb-3">Urban Renewal</span>
                    <div class="details w-100">
                        <span class="d-block mb-1 metric">
                            <% val=project.catWeights[cType[14]] %>
                                <% input=project.catInputs[cType[14]] %>
                                    <% if (sector=="Highway Construction" ) { max=40 %>
                                        Ability to spur urban renewal: <span class="selections">
                                            <%= input %> (<%= val %>/40)
                                        </span>
                                        <% } else if (sector=="Railway Construction" ) { max=20 %>
                                            Ability to spur urban renewal: <span class="selections">
                                                <%= input %> (<%= val%>/20)
                                            </span>
                                            <% } %>
                        </span>
                        <meter class="bar mb-3" value="<%= val %>" min="0" max="<%= max %>"></meter>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between vbuttons mx-auto">
                <div class="first3 d-flex">
                    <a href="/projects/edit/<%=project._id%>" class="v-btn mb-0">Edit Project</a>
                    <% if (project.projList=="standard" || project.projList=="execution" ) { %>
                        <button type="button" class="v-btn proj-btn mb-0 mx-md-2">Add to Priority List</button>
                        <% } else {%>
                            <button type="button" class="v-btn proj-btn mb-0 mx-md-2 remove">Remove from Priority
                                List</button>
                            <% } %>

                                <% if (project.projList=="standard" || project.projList=="priority" ) { %>
                                    <button type="button" class="v-btn proj-btn mb-0">Add to Execution List</button>
                                    <% } else {%>
                                        <button type="button" class="v-btn proj-btn mb-0 remove">Remove from
                                            Execution
                                            List</button>
                                        <% } %>

                                            <!-- Pass project id to script file -->
                                            <span id="pid" class="hidden mb-0">
                                                <%= project._id %>
                                            </span>
                </div>

                <form id="deleteProjectForm" class="mt-0 mb-5"
                    action="/projects/edit/<%=sector%>/<%=project._id%>?_method=DELETE" method="POST">
                    <button type="submit" class="delete mb-5">Delete
                        Project</button>
                </form>
            </div>
        </section>
    </div>
</div>                

<?php
    require_once './includes/components/footer.php';
?>