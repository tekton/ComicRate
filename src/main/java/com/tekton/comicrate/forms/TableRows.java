package com.tekton.comicrate.forms;

public class TableRows {
	public String name;
	public String type;
	public String value;
	public String label;
	public String size;
	public String other;
	
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	public String getType() {
		return type;
	}
	public void setType(String type) {
		this.type = type;
	}
	public String getValue() {
		return value;
	}
	public void setValue(String value) {
		this.value = value;
	}
	public String getLabel() {
		return label;
	}
	public void setLabel(String label) {
		this.label = label;
	}
	public String getSize() {
		return size;
	}
	public void setSize(String size) {
		this.size = size;
	}
	public String getOther() {
		return other;
	}
	public void setOther(String other) {
		this.other = other;
	}
	
	public TableRows(String label, String name, String type) {
		this.label = label;
		this.name = name;
		this.type = type;
	}
	
}
