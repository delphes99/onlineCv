// Global variables
var currentStyle;
var filter;
var activateFilter;
var filtersVisible;

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
			htmlElement.fadeOut('slow');
		},
		show : function() {
			var htmlElement = $('#experience_' + this.id).find('div.main_content_item_content');
			htmlElement.fadeIn('slow');
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
	                zIndex: 200
	            });
		}
	});
	
var SkillC = $.inherit(
	{
		__constructor : function(id, name, important) {
			this.id = id;
			this.name = name;
			this.important = important;
		},
		getId : function() {
			return this.id;
		},
		getName : function() {
			return this.name;
		},
		isImportant : function() {
			return this.important;
		}
	});
	
var FilterManagerC = $.inherit(
	{
		__constructor : function() {
			this.htmlElementFilter = $('#tabFilter');
			
			this.tabSkill = new Array();
			this.tabExperience = new Array();
			this.tabExperienceVisible = new Array();
			this.tabFilterIncSkill = new Array();
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
			this.addFilterSkillById(skill.getId());
		},
		toggleFilterSkillById : function(id) {
			if($.inArray(id, this.tabFilterIncSkill) != -1) {
				this.removeFilterSkillById(id);
			} else {
				this.addFilterSkillById(id);
			}
		},
		addFilterSkillById : function(id) {
			$(".tech_" + id).addClass('techSelected');
			this.tabFilterIncSkill.push(id);
			this.applyFilters();
		},
		removeFilterSkillById : function(id) {
			$(".tech_" + id).removeClass('techSelected');
			var indexSkill = $.inArray(id, this.tabFilterIncSkill);
			if(indexSkill != -1) {
				this.tabFilterIncSkill.splice(indexSkill, 1);
			}
			this.applyFilters();
		},
		removeAllFilterSkill : function() {
			$(".techSelected").removeClass('techSelected');
			this.tabFilterIncSkill = new Array();
			this.applyFilters();
		},
		applyFilters : function() {
			this.tabExperienceVisible = new Array();
			var expListCopy = this.tabExperience.slice(0);
			var exceptionNumber = 0;
			var countFilters = 0;
			
			for(skillId in this.tabFilterIncSkill) {
				if(skillId != null) {
					countFilters++;
				}
			}
			
			if(countFilters > 0) {
				// Show filters bar
				if(!filtersVisible) {
					$('#nav_filters').show();
					filtersVisible = true;
					
					if(activateFilter) {
						$('#activateFilter').prop('value', txtDesactivateFilter);
					} else {
						$('#activateFilter').prop('value', txtActivateFilter);
					}
				}
			} else {
				// Hide filters bar
				if(filtersVisible) {
					$('#nav_filters').hide();
					filtersVisible = false;
				}
			}
			
			// Apply skills filters
			var skillNumber = 0;
			if(activateFilter) {
				for(var i = 0; i < this.tabFilterIncSkill.length; i++) {
					var skillId = this.tabFilterIncSkill[i];
					skillNumber++;
					for(expCpId in expListCopy) {
						var expCp = expListCopy[expCpId];
						
						if(expCp.getSkills()[skillId] != null) {
							this.tabExperienceVisible[expCpId] = expCp;
							delete expListCopy[expCpId];
							expCp.show();
						}
					}
				}
			}
			
			if(skillNumber > 0) {
				// Hide all 
				for(expCpId in expListCopy) {
					expListCopy[expCpId].hide();
				}
			} else {
				// Show all
				for(expCpId in expListCopy) {
					this.tabExperienceVisible[expCpId] = expListCopy[expCpId];
					expListCopy[expCpId].show();
				}
			}
			this.generateFiltersList();
		},
		generateFiltersList : function() {
			var result = '';
			// Generate filters list
			for(var i = 0; i < this.tabFilterIncSkill.length; i++) {
				var skillId = this.tabFilterIncSkill[i];
				var skill = this.tabSkill[skillId];
				result += '<a class="tech_';
				result += skillId;
				result += ' skill';
				if(skill.isImportant()) {
					result += ' important_skill';
				}
				result += ' techSelected" onclick="javascript:toggleFilterSkill('
				result += skillId;
				result += ');">'
				result += skill.getName();
				result += '</a>';
			}
			this.htmlElementFilter.html(result);
			if($('#nav_filters').is(':visible')) {
				$('#container').css('margin-top', ($('#menu_bar').height() + $('#nav_filters').height()) + 'px');
			} else {
				$('#container').css('margin-top', $('#menu_bar').height() + 'px');
			}
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
	$('#switchCss').prop('href', 'css/style_' + name + '.css');
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

function toggleActivateFilter() {
	// Click append before set checked properties
	activateFilter = !activateFilter;
	
	if(activateFilter) {
		$('#activateFilter').prop('value', txtDesactivateFilter);
	} else {
		$('#activateFilter').prop('value', txtActivateFilter);
	}
	
	filter.applyFilters();
}

// Navigation Bar management
function toggleNavigationBar() {
	$('#nav_content').toggle();
}

// Tooltips
function addToolTips(id, text) {
	$(id).qtip({ 
		content: text,
		fixed: false,
		showEffect: 'none',
		hideEffect: 'none',
		offset: [10, 20],
		position : {
			my : 'left top',
			at : 'right bottom',
			viewport: $(window)
		}
	});
}

// Tooltips
function addToolTipsCompany(id, text) {
	$(id).qtip({ 
		content: text,
		fixed: false,
		showEffect: 'none',
		hideEffect: 'none',
		position : {
			my : 'right center',
			at : 'left center',
		}
	});
}

//Start-up script
$(document).ready(function() {
	// Enable default stylesheet
	switchStyle('green');
	
	// Load manager
	filter = new FilterManagerC();
	loadFilter();
	filtersVisible = false;
	activateFilter = true;
	
	$('#activateFilter').click(toggleActivateFilter);
	$('#hamburger').click(toggleNavigationBar);
	$('#nav_content').hide();
});