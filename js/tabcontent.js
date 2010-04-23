//** Tab Content script v2.0- © Dynamic Drive DHTML code library (http://www.dynamicdrive.com)

function ddtabcontent(tabinterfaceid){
    this.tabinterfaceid=tabinterfaceid 
	this.tabs=document.getElementById(tabinterfaceid).getElementsByTagName("a") 
	this.enabletabpersistence=true
	this.hottabspositions=[] 
	this.currentTabIndex=0 
	this.subcontentids=[] 
	this.revcontentids=[] 
	this.selectedClassTarget="link" }
ddtabcontent.getCookie=function(Name){ 
	var re=new RegExp(Name+"=[^;]+", "i"); 
	if (document.cookie.match(re))
		return document.cookie.match(re)[0].split("=")[1] 
	return ""}
ddtabcontent.setCookie=function(name, value){document.cookie = name+"="+value+";path=/" }
ddtabcontent.prototype={
	expandit:function(tabid_or_position){ 
		this.cancelautorun() 
		var tabref=""
		try{
			if (typeof tabid_or_position=="string" && document.getElementById(tabid_or_position).getAttribute("rel")) 
				tabref=document.getElementById(tabid_or_position)
			else if (parseInt(tabid_or_position)!=NaN && this.tabs[tabid_or_position].getAttribute("rel")) 
				tabref=this.tabs[tabid_or_position]	}
		catch(err){alert("Invalid Tab ID or position entered!")}
		if (tabref!="") 
			this.expandtab(tabref) },
	cycleit:function(dir, autorun){ 
		if (dir=="next"){
			var currentTabIndex=(this.currentTabIndex<this.hottabspositions.length-1)? this.currentTabIndex+1 : 0}
		else if (dir=="prev"){var currentTabIndex=(this.currentTabIndex>0)? this.currentTabIndex-1 : this.hottabspositions.length-1}
		if (typeof autorun=="undefined") 
			this.cancelautorun() 
		this.expandtab(this.tabs[this.hottabspositions[currentTabIndex]])},
	setpersist:function(bool){this.enabletabpersistence=bool},
	setselectedClassTarget:function(objstr){this.selectedClassTarget=objstr || "link"},
	getselectedClassTarget:function(tabref){return (this.selectedClassTarget==("linkparent".toLowerCase()))? tabref.parentNode : tabref},
	urlparamselect:function(tabinterfaceid){
		var result=window.location.search.match(new RegExp(tabinterfaceid+"=(\\d+)", "i")) 
		return (result==null)? null : parseInt(RegExp.$1)},
	expandtab:function(tabref){
		var subcontentid=tabref.getAttribute("rel") 
		var associatedrevids=(tabref.getAttribute("rev"))? ","+tabref.getAttribute("rev").replace(/\s+/, "")+"," : ""
		this.expandsubcontent(subcontentid)
		this.expandrevcontent(associatedrevids)
		for (var i=0; i<this.tabs.length; i++){ 
			this.getselectedClassTarget(this.tabs[i]).className=(this.tabs[i].getAttribute("rel")==subcontentid)? "selected" : ""}
		if (this.enabletabpersistence) 
			ddtabcontent.setCookie(this.tabinterfaceid, tabref.tabposition)
		this.setcurrenttabindex(tabref.tabposition)},
	expandsubcontent:function(subcontentid){
		for (var i=0; i<this.subcontentids.length; i++){
			var subcontent=document.getElementById(this.subcontentids[i]) 
			subcontent.style.display=(subcontent.id==subcontentid)? "block" : "none" }},
	expandrevcontent:function(associatedrevids){
		var allrevids=this.revcontentids
		for (var i=0; i<allrevids.length; i++){ 
			document.getElementById(allrevids[i]).style.display=(associatedrevids.indexOf(","+allrevids[i]+",")!=-1)? "block" : "none"}},
	setcurrenttabindex:function(tabposition){ 
		for (var i=0; i<this.hottabspositions.length; i++){
			if (tabposition==this.hottabspositions[i]){
				this.currentTabIndex=i
				break}}},
	autorun:function(){this.cycleit('next', true)},
	cancelautorun:function(){
	if (typeof this.autoruntimer!="undefined")
			clearInterval(this.autoruntimer)},
	init:function(automodeperiod){
		var persistedtab=ddtabcontent.getCookie(this.tabinterfaceid) 
		var selectedtab=-1
		var selectedtabfromurl=this.urlparamselect(this.tabinterfaceid) 
		this.automodeperiod=automodeperiod || 0
		for (var i=0; i<this.tabs.length; i++){
			this.tabs[i].tabposition=i 
			if (this.tabs[i].getAttribute("rel")){
				var tabinstance=this
				this.hottabspositions[this.hottabspositions.length]=i 
				this.subcontentids[this.subcontentids.length]=this.tabs[i].getAttribute("rel") 
				this.tabs[i].onclick=function(){
					tabinstance.expandtab(this)
					tabinstance.cancelautorun() 
					return false}
				if (this.tabs[i].getAttribute("rev")){this.revcontentids=this.revcontentids.concat(this.tabs[i].getAttribute("rev").split(/\s*,\s*/))}
				if (selectedtabfromurl==i || this.enabletabpersistence && selectedtab==-1 && parseInt(persistedtab)==i || !this.enabletabpersistence && selectedtab==-1 && this.getselectedClassTarget(this.tabs[i]).className=="selected"){
					selectedtab=i}}} 
		if (selectedtab!=-1) 
			this.expandtab(this.tabs[selectedtab])
		else 
			this.expandtab(this.tabs[this.hottabspositions[0]]) 
		if (parseInt(this.automodeperiod)>500 && this.hottabspositions.length>1){this.autoruntimer=setInterval(function(){tabinstance.autorun()}, this.automodeperiod)}}}