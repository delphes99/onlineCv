// Global variables
var currentStyle;
var filter;
var activateFilter;
var askActivateFilter;

// Classes
var ExperienceC = $.inherit(
	{
		__constructor : function(id, name) {
			this.name = name;
			this.id = id;
			this.classMax = 'experience_maximize';
			this.classMin = 'experience_minimize';
			this.classMaxSub = 'subExperience_maximize';
			this.classMinSub = 'subExperience_minimize';
			this.skills = new Array();
		},
		getName : function() {
			return this.name;
		},
		getId : function() {
			return this.id;
		},
		addSkill : function(skill) {
			this.skills[skill.getId()] = skill;
		},
		getSkills : function() {
			return this.skills;
		},
		hide : function() {
			var htmlElement = $('#experience_' + this.id).find('div.main_content_item_content');
			var expander = $('#expander_experience_' + this.id);
			htmlElement.fadeOut('slow');
			expander.removeClass(this.classMin);
			expander.addClass(this.classMax);
			expander.empty();
			expander.append('+');
		},
		show : function() {
			var htmlElement = $('#experience_' + this.id).find('div.main_content_item_content');
			var expander = $('#expander_experience_' + this.id);
			htmlElement.fadeIn('slow');
			expander.removeClass(this.classMax);
			expander.addClass(this.classMin);
			expander.empty();
			expander.append('-');
		},
		toggle : function() {
			var htmlElement = $('#experience_' + this.id).find('div.main_content_item_content');
			if(htmlElement.is(':visible')) {
				this.hide();
			} else {
				this.show();
			}
		},
		viewDetailExperience : function() {
			var htmlElement = $('#experienceDetails_' + this.id);
			htmlElement.bPopup({
	                zIndex: 2
	            });
		}
	});
	
var SkillC = $.inherit(
	{
		__constructor : function(id, name, icon) {
			this.id = id;
			this.name = name;
			this.icon = icon;
		},
		getId : function() {
			return this.id;
		},
		getName : function() {
			return this.name;
		},
		getIcon : function() {
			return this.icon;
		}
	});
	
var FilterManagerC = $.inherit(
	{
		__constructor : function() {
			this.htmlElementFilter = $('#tabFilter');
			this.htmlElementException = $('#tabException');
			
			this.tabSkill = new Array();
			this.tabExperience = new Array();
			this.tabExperienceVisible = new Array();
			// Include
			this.tabFilterIncExp = new Array();
			this.tabFilterIncSkill = new Array();
			// Exclude
			this.tabFilterExcExp = new Array();
		},
		addSkill : function(skill) {
			this.tabSkill[skill.getId()] = skill;
		},
		getSkill : function(id) {
			return this.tabSkill[id];
		},
		addExperience : function(exp) {
			this.tabExperience[exp.getId()] = exp;
			this.tabExperienceVisible[exp.getId()] = exp;
		},
		getExperience : function(id) {
			return this.tabExperience[id];
		},
		addFilterSkill : function(skill) {
			$(".tech_" + skill.getId()).addClass('techSelected');
			this.tabFilterIncSkill[skill.getId()] = skill;
			this.applyFilters();
		},
		toggleFilterSkillById : function(id) {
			if(askActivateFilter) {
				fctActivateFilter(true);
				displayNavigationBar();
				askActivateFilter = false;
			}
			if(this.tabFilterIncSkill[id] != null) {
				this.removeFilterSkillById(id);
			} else {
				this.addFilterSkillById(id);
			}
		},
		addFilterSkillById : function(id) {
			$(".tech_" + id).addClass('techSelected');
			this.tabFilterIncSkill[id] = this.tabSkill[id];
			this.applyFilters();
		},
		removeFilterSkillById : function(id) {
			$(".tech_" + id).removeClass('techSelected');
			delete this.tabFilterIncSkill[id];
			this.applyFilters();
		},
		removeAllFilterSkill : function() {
			$(".techSelected").removeClass('techSelected');
			this.tabFilterIncSkill = new Array();
			this.applyFilters();
		},
		addFilterExperience : function(exp, include) {
			if(include) {
				this.tabFilterIncExp[exp.getId()] = exp;
			} else {
				this.tabFilterExcExp[exp.getId()] = exp;
			}
			this.applyFilters();
		},
		addFilterExperienceById : function(id, include) {
			if(include) {
				this.tabFilterIncExp[id] = this.tabExperience[id];
			} else {
				this.tabFilterExcExp[id] = this.tabExperience[id];
			}
			this.applyFilters();
		},
		removeFilterExperienceById : function(id, include) {
			if(include) {
				delete this.tabFilterIncExp[id];
			} else {
				delete this.tabFilterExcExp[id];
			}
			this.applyFilters();
		},
		removeAllFilterExperience : function() {
			this.tabFilterIncExp = new Array();
			this.tabFilterExcExp = new Array();
			this.applyFilters();
		},
		toggleExperience : function(id) {
			if(this.tabExperienceVisible[id] != null) {
				this.tabFilterExcExp[id] = this.tabExperience[id];
				this.tabExperience[id].hide();
				delete this.tabFilterIncExp[id];
				delete this.tabExperienceVisible[id];
			} else {
				this.tabExperienceVisible[id] = this.tabExperience[id];
				this.tabFilterIncExp[id] = this.tabExperience[id];
				this.tabExperience[id].show();
				delete this.tabFilterExcExp[id];
			}
			this.applyFilters();
		},
		applyFilters : function() {
			this.tabExperienceVisible = new Array();
			var expListCopy = this.tabExperience.slice(0);
			var exceptionNumber = 0;
			// Exclude
			for(expId in this.tabFilterExcExp) {
				if(expListCopy[expId] != null) {
					expListCopy[expId].hide();
					delete expListCopy[expId];
					exceptionNumber++;
				}
			}
			
			// Include
			for(expId in this.tabFilterIncExp) {
				if(expListCopy[expId] != null) {
					this.tabExperienceVisible[expId] = expListCopy[expId];
					expListCopy[expId].show();
					delete expListCopy[expId];
					exceptionNumber++;
					break;
				}
			}
			
			// Apply skills filters
			var skillNumber = 0;
			if(activateFilter) {
				for(skillId in this.tabFilterIncSkill) {
					skillNumber++;
					for(expCpId in expListCopy) {
						var expCp = expListCopy[expCpId];
						
						if(expCp.getSkills()[skillId] != null) {
							this.tabExperienceVisible[expCpId] = expListCopy[expCpId];
							expListCopy[expCpId].show();
							delete expListCopy[expCpId];
						}
					}
				}
			}
			
			if(exceptionNumber > 0) {
				$('#listExceptions').show();
			} else {
				$('#listExceptions').hide();
			}
			
			if(skillNumber > 0) {
				// Hide all 
				for(expCpId in expListCopy) {
					expListCopy[expCpId].hide();
				}
				$('#listFilters').show();
			} else {
				// Show all
				for(expCpId in expListCopy) {
					this.tabExperienceVisible[expCpId] = expListCopy[expCpId];
					expListCopy[expCpId].show();
				}
				$('#listFilters').hide();
			}
			this.generateFiltersList();
		},
		generateFiltersList : function() {
			var result = '';
			// Generate filters list
			for(skillId in this.tabFilterIncSkill) {
				var skill = this.tabFilterIncSkill[skillId];
				var typeSkillClass = '';
				var typeSkillAlt = skill.getIcon();
				result += '<tr class="filter">';
				result += '<td><img class="delete" onclick="javascript:filter.removeFilterSkillById(\'' + skillId + '\');"></td>';
				result += '<td><img alt="' + typeSkillAlt + '" class="' + typeSkillClass + '">' + skill.getName() + '</td>';
				result += '</tr>';
			}
			this.htmlElementFilter.html(result);
			
			result = '';
			for(expId in this.tabFilterExcExp) {
				var exp = this.tabFilterExcExp[expId];
				result += '<tr class="filter">';
				result += '<td><img class="delete" onclick="javascript:filter.removeFilterExperienceById(\'' + expId + '\', false);"></td>';
				result += '<td><img alt="todo" class="filterHidden"></td>';
				result += '<td>' + exp.getName() + '</td>';
				result += '</tr>';
			}
			
			for(expId in this.tabFilterIncExp) {
				var exp = this.tabFilterIncExp[expId];
				result += '<tr class="filter">';
				result += '<td><img class="delete" onclick="javascript:filter.removeFilterExperienceById(\'' + expId + '\', true);"></td>';
				result += '<td><img alt="todo" class="filterVisible"></td>';
				result += '<td>' + exp.getName() + '</td>';
				result += '</tr>';
			}
			this.htmlElementException.html(result);
		}
	});

// Actions

/**
 * Change style
 * @param name
 */
function switchStyle(name) {
	currentStyle = name;
	// Main stylesheet
	$('#switchCss').prop('href', baseUrl + '/css/style_' + name + '.css');
}
/**
 * Toggle the experience visibility
 * @param idExperience
 */
function toggleExperience(idExperience) {
	filter.toggleExperience(idExperience);
}

/**
 * 
 * @param idExperience
 */
function viewDetailExperience(idExperience) {
	filter.getExperience([idExperience]).viewDetailExperience();
}

/**
 * Toggle Filter skill
 * @param idSkill
 */
function toggleFilterSkill(idSkill) {
	filter.toggleFilterSkillById(idSkill);
}

/**
 * Remove filter skill
 * @param idSkill
 */
function removeFilterSkill(idSkill) {
	filter.removeFilterSkillById(idSkill);
}

/**
 * Remove all filter skill
 */
function removeAllFilterSkill() {
	filter.removeAllFilterSkill();
};

/**
 * Remove all filter exception
 */
function removeAllFilterExperience() {
	filter.removeAllFilterExperience();
}

/**
 * Toggle skills display
 * @param type
 */
function toggleSkills(type) {
	if($('#expander_'+type).hasClass('experience_maximize')) {
		showSkills(type);
	} else {
		hideSkills(type);
	}
}

/**
 * Maximize skill type
 * @param type
 */
function showSkills(type) {
	var htmlElement = $('#' + type + '_maximize');
	var expander = $('#expander_' + type);
	var htmlElementMini = $('#' + type + '_minimize');
	htmlElementMini.fadeOut('fast', function() { htmlElement.fadeIn('slow'); });
	expander.removeClass('experience_maximize');
	expander.addClass('experience_minimize');
}


/**
 * Minimize skill type
 * @param type
 */
function hideSkills(type) {
	var htmlElement = $('#' + type + '_maximize');
	var expander = $('#expander_' + type);
	var htmlElementMini = $('#' + type + '_minimize');
	htmlElement.fadeOut('fast', function() { htmlElementMini.fadeIn('slow'); });
	expander.addClass('experience_maximize');
	expander.removeClass('experience_minimize');
}

function fctActivateFilter(activate) {
	$('#activateFilter').prop('checked', activate);
	activateFilter = activate;
	filter.applyFilters();
}

function toggleActivateFilter() {
	// Click append before set checked properties
	fctActivateFilter($('#activateFilter').is(':checked'));
}

// Navigation Bar management
function toggleNavigationBar() {
	$('#nav_content').toggle();
	//$('#container').css('margin-left', $('#navigation').outerWidth(true));
}

function displayNavigationBar() {
	$('#nav_content').show();
	//$('#container').css('margin-left', $('#navigation').outerWidth(true));
}

// Tooltips
function addToolTips(id, text) {
	$(id).qtip({ 
		content: text,
		fixed: false,
		showEffect: 'none',
		hideEffect: 'none',
		offset: [10, 20]
	});
}

//Start-up script
$(document).ready(function() {
	// Enable default stylesheet
	switchStyle('white');
	
	// Load manager
	filter = new FilterManagerC();
	loadFilter();
	askActivateFilter = true;
	fctActivateFilter(false);
	
	$('#removeAllFilterSkill').click(removeAllFilterSkill);
	$('#removeAllFilterExperience').click(removeAllFilterExperience);
	$('#activateFilter').click(toggleActivateFilter);
	$('#hamburger').click(toggleNavigationBar);
	$('#nav_content').hide();
});