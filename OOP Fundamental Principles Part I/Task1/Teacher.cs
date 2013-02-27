using System;
using System.Collections.Generic;
using System.Linq;

namespace Task1
{
    class Teacher : People
    {
        public List<Discipline> Discplines { get; set; }
        public string Comment { get; set; }
       
        public Teacher(string name)
        {
            this.Discplines = new List<Discipline>();
            this.Name = name;
        }
        
        
    }
}
